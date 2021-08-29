<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use HelpDesk\Http\Requests\Config\Statuses\CreateStatusRequest;
use HelpDesk\Http\Requests\Config\Statuses\UpdateStatusRequest;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class StatusesController extends Controller
{
    public function index()
    {
        return view('admin.statuses.index');
    }

    public function datatables()
    {
        $query = Status::query();

        return DataTables::eloquent($query)
            ->editColumn('color',function($model){
                return "<div style='background-color: {$model->color};border:darkgray 1px solid; width:1rem;height:1rem;display:inline-block;'></div> {$model->color}";
            })
            ->addColumn('buttons', 'admin.statuses.datatables._buttons')
            ->rawColumns(['buttons','color'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('status_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.statuses.create', [
            'model' => new Status(),
        ]);
    }

    public function store(CreateStatusRequest $request)
    {
        DB::beginTransaction();
        try {
            Status::create($request->all());

            DB::commit();

            return redirect()
                ->route('admin.estatus.index')
                ->with(['message' => 'Estatus creado Correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function edit(Status $model)
    {
        abort_unless(Entrust::can('status_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.statuses.edit', [
            'model' => $model,
        ]);
    }

    public function update(UpdateStatusRequest $request, Status $model)
    {
        DB::beginTransaction();
        try {

            $model->update($request->all());

            DB::commit();

            return redirect()
                ->route('admin.estatus.index')
                ->with(['message' => 'Estatus actualizado correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function show(Status $model)
    {
        abort_unless(Entrust::can('status_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.statuses.show', ['model' => $model]);
    }

    public function destroy(Status $model)
    {
        abort_unless(Entrust::can('status_delete'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->delete();

        return redirect()
            ->back()
            ->with(['message' => 'Estatus eliminado correctamente']);
    }

    public function massDestroy(Request $request)
    {
        Status::whereIn('id', $request->input('ids'))->delete();

        return response(null, HTTPMessages::HTTP_NO_CONTENT);
    }
}
