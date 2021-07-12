<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Inventario\Sucursal;

class SucursalController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.sucursales.index');
    }

    public function datatables()
    {
        $query = Sucursal::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.sucursales.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        return view('gestion-inventarios.sucursales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        Sucursal::create($request->except('_token'));

        return redirect()
            ->route('gestion-inventarios.sucursales.index')
            ->with(['message' => 'Sucursal creada correctamente']);
    }

    public function edit(Sucursal $sucursal)
    {
        return view('gestion-inventarios.sucursales.edit',compact('sucursal'));
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $sucursal->fill($request->except('_token'));
        $sucursal->save();

        return redirect()
            ->route('gestion-inventarios.sucursales.index')
            ->with(['message' => 'Sucursal editado correctamente']);
    }

    public function destroy(Sucursal $sucursal, Request $request)
    {
        $sucursal->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Sucursal eliminada correctamente'
            ], 200);
        }

        return redirect()
            ->route('gestion-inventarios.equipos.index')
            ->with(['message' => 'Sucursal eliminada correctamente']);
    }


    public function select2(Request $request)
    {
        $term  = $request->input('term');
        $page = $request->input('page');
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $results = Sucursal::query()
            ->where('descripcion', 'like', '%' . $term . '%')
            ->orderBy('descripcion')
            ->skip($offset)
            ->take($resultCount)->get();

        $count = Sucursal::query()
            ->where('descripcion', 'like', '%' . $term . '%')
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
