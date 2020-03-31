<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use HelpDesk\Http\Requests\Admin\Departamentos\CreateDepartamentoRequest;
use HelpDesk\Http\Requests\Admin\Departamentos\UpdateDepartamentoRequest;

class DepartamentsController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('departament_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departaments.index', [ 'collection' => Departamento::paginate() ]);
    }

    public function create()
    {
        abort_unless(Entrust::can('departament_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departaments.create', [
            'model' => new Departamento()
        ]);
    }

    public function store(CreateDepartamentoRequest $request)
    {
        DB::beginTransaction();
        try {
            Departamento::create($request->all());

            DB::commit();

            return redirect()
                ->route('admin.departamentos.index')
                ->with(['message' => 'Departamento Creado Correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor:{$e->getMessage()}",])
                ->withInput();
        }
    }

    public function edit(Departamento $model)
    {
        abort_unless(Entrust::can('departament_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departaments.edit', [
            'model' => $model
        ]);
    }

    public function update(UpdateDepartamentoRequest $request, Departamento $model)
    {
        DB::beginTransaction();
        try {
            $model->update($request->all());

            DB::commit();

            return redirect()
                ->route('admin.departamentos.index')
                ->with(['message' => 'Departamento actualizado correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()}"])
                ->withInput();
        }
    }

    public function show(Departamento $model)
    {
        abort_unless(Entrust::can('departament_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departaments.show', ['model' => $model]);
    }

    public function destroy(Departamento $model)
    {
        abort_unless(Entrust::can('departament_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->delete();

        return redirect()
            ->back()
            ->with(['message' => 'Departamento eliminado correctamente']);
    }

    public function massDestroy(Request $request)
    {
        Departamento::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
