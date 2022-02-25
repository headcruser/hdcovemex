<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Admin\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Imports\PersonalImport;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Inventario\Personal;
use HelpDesk\Entities\Inventario\CuentaPersonal;
use HelpDesk\Entities\Inventario\Sucursal;
use Maatwebsite\Excel\Validators\ValidationException;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class PersonalController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.personal.index',[
            'departamentos' => Departamento::pluck('nombre', 'id')->prepend('Todos', ''),
            'sucursales'    => Sucursal::pluck('descripcion','id')->prepend('Todos','')
        ]);
    }

    public function datatables(Request $request)
    {
        $query = Personal::query()
            ->select('personal.id','personal.id_impresion' ,'personal.nombre', 'personal.id_sucursal', 'personal.id_departamento', 'personal.id_usuario')
            ->when($request->input('id_sucursal'),function($q,$id_sucursal){
                $q->where('id_sucursal',$id_sucursal);
            })
            ->when($request->input('id_departamento'),function($q,$id_departamento){
                $q->where('id_departamento',$id_departamento);
            })
            ->with(['sucursal', 'departamento']);

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.personal.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function show(Personal $personal)
    {
        $personal->load(['sucursal', 'departamento']);
        return view('gestion-inventarios.personal.show', compact('personal'));
    }

    public function create(Request $request)
    {
        $personal = new Personal;
        return view('gestion-inventarios.personal.create', compact('personal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'            => 'required',
            'id_departamento'   => 'required',
            'id_sucursal'       => 'required',
        ]);

        $id_impresion = $request->input('id_impresion') ?? null;

        $request->merge([
            'id_impresion' => $id_impresion
        ]);


        Personal::create($request->except('_token'));

        return redirect()
            ->route('gestion-inventarios.personal.index')
            ->with(['message' => 'Personal creado correctamente']);
    }

    public function edit(Personal $personal)
    {
        $personal->load(['sucursal', 'departamento','cuentas']);

        return view('gestion-inventarios.personal.edit', compact('personal'));
    }

    public function update(Request $request, Personal $personal)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $id_impresion = $request->input('id_impresion') ?? null;


        $request->merge([
            'id_impresion' => $id_impresion
        ]);

        $personal->update($request->except('_token'));

        return redirect()
            ->route('gestion-inventarios.personal.index')
            ->with(['message' => 'Personal editado correctamente']);
    }

    public function destroy(Personal $personal, Request $request)
    {
        $personal->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Personal eliminado correctamente'
            ], 200);
        }

        return redirect()
            ->route('gestion-inventarios.personal.index')
            ->with(['message' => 'Personal elimnado correctamente']);
    }


    public function listar_cuentas(Request $request)
    {
        $personal = Personal::findOrFail($request->input('id_personal'));

        $personal->load(['cuentas']);

        $lista = (string) view('gestion-inventarios.personal.partials._cuentas',compact('personal'));

        return response()->json([
            'template' => $lista
        ], 200);
    }

    public function agregar_cuenta(Request $request)
    {
        $data = $request->validate([
            'titulo'        => 'required',
            'usuario'       => 'nullable',
            'contrasenia'   => 'nullable',
            'descripcion'   => 'nullable',
            'id_personal'   => 'required',
        ]);

        CuentaPersonal::create($data);

        return response()->json([
            'message' => 'Cuenta agregada correctamnte',
        ], 200);
    }

    public function actualizar_cuenta(Request $request,CuentaPersonal $cuenta)
    {
        $data = $request->validate([
            'titulo'        => 'required',
            'usuario'       => 'nullable',
            'contrasenia'   => 'nullable',
            'descripcion'   => 'nullable',
            'id_personal'   => 'required'
        ]);

        $cuenta->fill($data);
        $cuenta->save();

        return response()->json([
            'message' => 'Cuenta actualizada correctamente',
        ], 200);

    }

    public function eliminar_cuenta(CuentaPersonal $cuenta)
    {
        $cuenta->delete();

        return response()->json([
            'message' => 'Cuenta eliminada correctamente',
        ], 200);
    }

    public function select2(Request $request)
    {
        $term  = $request->input('term');
        $page = $request->input('page');
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $results = Personal::query()
            ->where('nombre', 'like', '%' . $term . '%')
            ->orderBy('nombre')
            ->skip($offset)
            ->take($resultCount)->get();

        $count = Personal::query()
            ->where('nombre', 'like', '%' . $term . '%')
            ->count();

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        return response()->json([
            "results" => $results,
            "pagination" => [
                "more" => $morePages
            ]
        ]);
    }

    public function importar(Request $request)
    {
        $this->validate($request, [
            'personal' => 'required|mimes:xls,xlsx'
        ]);

        $archivo = $request->file('personal');

         try {
            DB::beginTransaction();

            $import = new PersonalImport;
            $import->import($archivo);

            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Personal Importado correctamente',
            ]);
        } catch (ValidationException $e) {
            DB::rollback();
            $failures = $e->failures();

            return response()->json([
                'success'   => false,
                'error'     => 'Error al importar el personal',
                'details'   => optional($failures[0])->errors()
            ],HTTPMessages::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
