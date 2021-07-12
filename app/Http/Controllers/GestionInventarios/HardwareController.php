<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Inventario\Hardware;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HardwareController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.hardware.index');
    }

    public function datatables()
    {
        $query = Hardware::query()->with('tipo');

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.hardware.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        return view('gestion-inventarios.hardware.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        Hardware::create($request->except('_token'));

        return redirect()
            ->route('gestion-inventarios.hardware.index')
            ->with(['message' => 'Hardware agregado correctamente']);
    }

    public function edit(Hardware $hardware)
    {
        return view('gestion-inventarios.hardware.edit',compact('hardware'));
    }

    public function update(Request $request, Hardware $hardware)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $hardware->fill($request->except('_token'));
        $hardware->save();

        return redirect()
            ->route('gestion-inventarios.hardware.index')
            ->with(['message' => 'Hardware editado correctamente']);
    }

    public function destroy(Hardware $hardware, Request $request)
    {
        $hardware->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'hardware eliminado correctamente'
            ], 200);
        }

        return redirect()
            ->route('gestion-inventarios.hardware.index')
            ->with(['message' => 'Hardware eliminado correctamente']);
    }

    public function select2(Request $request)
    {
        $term  = $request->input('term');
        $page = $request->input('page');
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $results = Hardware::query()
            ->where(function($q) use($term){
                $q->where('descripcion', 'like', '%' . $term . '%')
                ->where('no_serie','like', '%' . $term . '%')
                ->where('marca','like', '%' . $term . '%');
            })
            ->when($request->input('no_asignado'),function($q){
                $q->where('asignado',0);
            })

            ->orderBy('descripcion')
            ->skip($offset)
            ->take($resultCount)->get();

        $count = Hardware::query()
            ->where(function($q) use($term){
                $q->where('descripcion', 'like', '%' . $term . '%')
                ->where('no_serie','like', '%' . $term . '%')
                ->where('marca','like', '%' . $term . '%');
            })
            ->when($request->input('no_asignado'),function($q){
                $q->where('asignado',0);
            })
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
