<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Inventario\Credencial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;


class CredencialesController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.credenciales.index');
    }

    public function datatables()
    {
        $query = Credencial::query();

        return DataTables::eloquent($query)
            ->editColumn('url',function($model){
                if(empty($model->url)){
                    return '';
                }

                if (filter_var($model->url, FILTER_VALIDATE_URL) !== false) {
                    return "<a class='btn-link' target='_blank' href='{$model->url}' title='Enlace'>{$model->url}</a>";
                }

                return $model->url;
            })
            ->addColumn('buttons', 'gestion-inventarios.credenciales.datatables._buttons')
            ->rawColumns(['buttons','url'])
            ->make(true);
    }

    public function create()
    {
        return view('gestion-inventarios.credenciales.create',[
            'credencial' => new Credencial()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        Credencial::create($request->except('_token'));

        return redirect()
            ->route('gestion-inventarios.credenciales.index')
            ->with(['message' => 'Credencial creada correctamente']);
    }

    public function edit(Credencial $credencial)
    {
        return view('gestion-inventarios.credenciales.edit',compact('credencial'));
    }

    public function update(Request $request, Credencial $credencial)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $credencial->fill($request->except('_token'));
        $credencial->save();

        return redirect()
            ->back()
            ->with(['message' => 'Credencial editada correctamente']);
    }

    public function destroy(Credencial $credencial, Request $request)
    {
        $credencial->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Credencial eliminada correctamente'
            ], 200);
        }

        return redirect()
            ->route('gestion-inventarios.credenenciales.index')
            ->with(['message' => 'Credencial eliminada correctamente']);
    }
}
