<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Inventario\CuentaPersonal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Inventario\Personal;

class PersonalController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.personal.index');
    }

    public function datatables(Request $request)
    {
        $query = Personal::query()
            ->select('id', 'nombre', 'id_sucursal', 'id_departamento', 'id_usuario')
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
            'descripcion'   => 'required',
            'id_personal'   => 'required'
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
            'descripcion'   => 'required',
            'id_personal'   => 'required'
        ]);

        $cuenta->update($data);

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
}
