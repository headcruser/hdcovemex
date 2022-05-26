<?php

namespace HelpDesk\Http\Controllers\GestionImpresiones;

use Illuminate\Http\Request;
use HelpDesk\Entities\Impresora;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;

class ImpresorasController extends Controller
{
    public function index()
    {
        return view('gestion-impresiones.impresoras.index');
    }

    public function datatables()
    {
        $query = Impresora::query();

        return DataTables::eloquent($query)
            ->editColumn('ip',function($model){
                return "<a href='{$model->ip}' target='_blank' class='btn-link'>{$model->ip}</a>";
            })
            ->addColumn('buttons', 'gestion-impresiones.impresoras.datatables._buttons')
            ->rawColumns(['ip','buttons' ])
            ->make(true);
    }

    public function show(Impresora $impresora)
    {
        return view('gestion-impresiones.impresoras.show', ['impresora' => $impresora]);
    }

    public function create()
    {
        return view('gestion-impresiones.impresoras.create', [
            'model' => new Impresora(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required',
            'descripcion'   => 'required',
            'nip'           => 'required',
            'ip'           => 'required',
        ]);

        DB::beginTransaction();

        try {
            Impresora::create($request->all());

            DB::commit();

            return redirect()
                ->route('gestion-impresiones.impresoras.index')
                ->with(['message' => 'Impresora creada Correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function edit(Impresora $impresora)
    {
        return view('gestion-impresiones.impresoras.edit', [
            'impresora' => $impresora,
        ]);
    }

    public function update(Request $request, Impresora $impresora)
    {
        $request->validate([
            'nombre'        => 'required',
            'descripcion'   => 'required',
            'nip'           => 'required',
            'ip'           => 'required',
        ]);

        DB::beginTransaction();

        try {

            $impresora->update($request->all());

            DB::commit();

            return redirect()
                ->route('gestion-impresiones.impresoras.index')
                ->with(['message' => 'Estatus actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function destroy(Request $request, Impresora $impresora)
    {
        $impresora->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "La impresora se elimino con éxito",
            ]);
        }

        return redirect()->back()->with([
            'message'   => "La impresora se elimino con éxito",
        ]);
    }
}
