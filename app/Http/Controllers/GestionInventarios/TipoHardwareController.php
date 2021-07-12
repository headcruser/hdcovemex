<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Inventario\TipoHardware;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TipoHardwareController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.tipo-hardware.index');
    }

    public function datatables()
    {
        $query = TipoHardware::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.tipo-hardware.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        return view('gestion-inventarios.tipo-hardware.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion'            => 'required',
        ]);

        TipoHardware::create($request->except('_token'));

        return redirect()
            ->route('gestion-inventarios.tipo-hardware.index')
            ->with(['message' => 'Tipo de hardware agregado correctamente']);
    }

    public function edit(TipoHardware $tipoHardware)
    {
        return view('gestion-inventarios.tipo-hardware.edit',compact('tipoHardware'));
    }

    public function update(Request $request, TipoHardware $tipoHardware)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $tipoHardware->fill($request->except('_token'));
        $tipoHardware->save();

        return redirect()
            ->route('gestion-inventarios.tipo-hardware.index')
            ->with(['message' => 'Personal editado correctamente']);
    }

    public function destroy(TipoHardware $tipoHardware, Request $request)
    {
        $tipoHardware->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Tipo de hardware eliminado correctamente'
            ], 200);
        }

        return redirect()
            ->route('gestion-inventarios.tipo-hardware.index')
            ->with(['message' => 'Tipo de hardware eliminado correctamente']);
    }

    public function select2(Request $request)
    {
        $term  = $request->input('term');
        $page = $request->input('page');
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $results = TipoHardware::query()
            ->where('descripcion', 'like', '%' . $term . '%')
            ->orderBy('descripcion')
            ->skip($offset)
            ->take($resultCount)->get();

        $count = TipoHardware::query()
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
