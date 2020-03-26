<?php

namespace HelpDesk\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Admin\Permission;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use HelpDesk\Http\Requests\Admin\Permisos\{CreatePermisoRequest, UpdatePermisoRequest};
use Entrust;

class PermisosController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permisos.index', ['collection' => Permission::paginate() ]);
    }

    public function create()
    {
        abort_unless(Entrust::can('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permisos.create', ['model' => new Permission()]);
    }

    public function store(CreatePermisoRequest $request)
    {
        DB::beginTransaction();
        try {
            Permission::create($request->all());
            DB::commit();

            return redirect()
                ->route('admin.permisos.index')
                ->with(['message' => 'Permiso Creado correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()} ",])->withInput();
        }
    }

    public function edit(Permission $model)
    {
        abort_unless(Entrust::can('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permisos.edit', ['model'=> $model]);
    }

    public function update(UpdatePermisoRequest $request, Permission $model)
    {
        DB::beginTransaction();
        try {

            $model->update($request->all());

            DB::commit();

            return  redirect()
                ->route('admin.permisos.index')
                ->with(['message' => 'Permiso actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function show(Permission $model)
    {
        abort_unless(Entrust::can('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permisos.show', ['model'=> $model]);
    }

    public function destroy(Permission $model)
    {
        abort_unless(Entrust::can('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Permission::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
