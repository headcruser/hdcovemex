<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use Illuminate\Http\Request;
use HelpDesk\Entities\Impresion;
use HelpDesk\Entities\Impresora;
use HelpDesk\Enums\Meses;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Services\PrinterCanon;
use Illuminate\Validation\ValidationException;

class ImpresionesController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.impresiones.index');
    }

    public function datatables()
    {
        $query = Impresion::query();

        return DataTables::eloquent($query)
            ->editColumn('mes', function ($model) {
                return $model->nombre_mes;
            })
            ->editColumn('fecha', function ($model) {
                return optional($model->fecha)->format('d-m-Y');
            })
            ->addColumn('buttons', 'gestion-inventarios.impresiones.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function show(Impresion $impresion)
    {
        $impresion->load(['detalles.impresora']);

        $detalles_por_impresora = $impresion->detalles->groupBy(function($detalle){
            return $detalle->impresora->descripcion;
        });

        $ids_impresororas = $impresion->detalles->pluck('id_impresora')->unique()->flatten()->toArray() ?? [];
        $impresoras_registradas = Impresora::find($ids_impresororas);
        // dd($impresoras_registradas->firstWhere('id',1));

        return view('gestion-inventarios.impresiones.show', [
            'impresion'                 => $impresion,
            'impresoras'                => Impresora::query()->pluck('descripcion', 'id')->prepend('Selecciona una impresora', ''),
            'impresoras_registradas'    => $impresoras_registradas,
            'detalles_por_impresora'    => $detalles_por_impresora,
        ]);
    }

    public function create()
    {
        return view('gestion-inventarios.impresiones.create', [
            'impresion'         => new Impresion(),
            'impresoras'        => Impresora::query()->pluck('descripcion', 'id')->prepend('Selecciona una impresora', ''),
            'meses'             => collect(Meses::asSelectArray())->prepend('Selecciona un mes', '')
        ]);
    }

    public function store(Request $request, PrinterCanon $printer)
    {
        $request->validate([
            'anio'          => 'required',
            'mes'           => 'required',
            'creado_por'    => 'required',
            'fecha'         => 'required',
        ]);

        $existe_reporte_mensual = Impresion::query()
            ->where('anio', $request->input('anio'))
            ->where('mes', $request->input('mes'))
            ->exists();

        if ($existe_reporte_mensual) {
            return back()
                ->with(['error' => 'El reporte ya existe para el mes de ' . Meses::getKey((int)$request->input('mes'))])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $impresion = Impresion::create($request->all());

            if ($request->has('agregar_informacion_impresora')) {
                $printer->read($request->input('info'));

                $registro_impresiones = $printer->toCollection();

                $registro_impresiones->each(function ($registro) use ($impresion, $request) {
                    $impresion->detalles()->create([
                        'id_impresion' => $registro->id,
                        'negro'        => $registro->negro ?? 0,
                        'color'        => $registro->color ?? 0,
                        'total'        => $registro->total ?? 0,
                        'id_impresora' => $request->input('id_impresora'),
                    ]);
                });

                $impresion->negro = $registro_impresiones->sum('negro');
                $impresion->color = $registro_impresiones->sum('color');
                $impresion->total = $registro_impresiones->sum('total');
                $impresion->save();
            }

            DB::commit();

            return redirect()->route('gestion-inventarios.impresiones.show', $impresion)
                ->with(['message' => 'Reporte Impresion Creado correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function destroy(Request $request, Impresion $impresion)
    {
        $impresion->detalles()->delete();
        $impresion->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Registro eliminado correctamente',
                'id'        => $impresion->id
            ]);
        }

        return redirect()->route('gestion-inventarios.impresiones.index')->with([
            'message' => 'Registro eliminado correctamente'
        ]);
    }

    public function agregar_registro_impresiones(Impresion $impresion,Request $request,PrinterCanon $printer)
    {
        $request->validate([
            'info'          => 'required',
            'id_impresora'  => 'required|exists:impresoras,id',
        ]);

        $existe_impresora = $impresion->detalles()->where('id_impresora', $request->input('id_impresora'))->exists();

        if ($existe_impresora) {
            return back()
                ->with(['error' => 'Ya has agregado la impresora anteriormente'])
                ->withInput();
        }

        $printer->read($request->input('info'));

        $registro_impresiones = $printer->toCollection();

        $registro_impresiones->each(function ($registro) use ($impresion, $request) {
            $impresion->detalles()->create([
                'id_impresion' => $registro->id,
                'negro'        => $registro->negro ?? 0,
                'color'        => $registro->color ?? 0,
                'total'        => $registro->total ?? 0,
                'id_impresora' => $request->input('id_impresora'),
            ]);
        });

        $impresion->negro += $registro_impresiones->sum('negro');
        $impresion->color += $registro_impresiones->sum('color');
        $impresion->total += $registro_impresiones->sum('total');
        $impresion->save();


        return redirect()
            ->route('gestion-inventarios.impresiones.show', $impresion)
            ->with(['message' => 'Reporte Impresion agregado correctamente']);
    }

    public function eliminar_registros_impresiones(Impresion $impresion, Request $request)
    {
        $request->validate([
            'id_impresora'  => 'required|exists:impresoras,id',
        ]);

        $impresion->detalles()
            ->where('id_impresora',$request->input('id_impresora'))
            ->delete();

        $impresion->negro = 0;
        $impresion->color = 0;
        $impresion->total = 0;

        $impresion->save();

        return redirect()
            ->route('gestion-inventarios.impresiones.show', $impresion)
            ->with(['message' => 'Registros eliminados correctamente']);
    }
}
