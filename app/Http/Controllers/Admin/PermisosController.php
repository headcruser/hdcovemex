<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\Role;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Admin\Permission;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use HelpDesk\Http\Requests\Admin\Permisos\{CreatePermisoRequest, UpdatePermisoRequest};

class PermisosController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('permission_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.permisos.index');
    }

    public function datatables()
    {
        $query = Permission::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'admin.permisos.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('permission_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

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
        abort_unless(Entrust::can('permission_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.permisos.edit', ['model' => $model]);
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
        abort_unless(Entrust::can('permission_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.permisos.show', ['model' => $model]);
    }

    public function destroy(Request $request,Permission $model)
    {
        $model->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El permiso se elimino con éxito",
            ]);
        }

        return redirect()->back()->with([
            'message'   => "El permiso se elimino con éxito",
        ]);

        return back();
    }

    public function massDestroy(Request $request)
    {
        Permission::whereIn('id', $request->input('ids'))->delete();

        return response(null, HTTPMessages::HTTP_NO_CONTENT);
    }

    public function asignar()
    {
        return view('admin.permisos.asignar', [
            'roles'     => Role::get(),
            'permisos'  => Permission::get(),
        ]);
    }

    public function guardar_permiso(Request $request)
    {
        $role = Role::find($request->id_role);
        $permiso = Permission::find($request->id_permission);

        if ($role->perms->where('id', $request->id_permission)->count() == 0) {
            $role->attachPermission($permiso);
        } else {
            $role->perms()->detach($request->id_permission);
        }

        return $role->perms;
    }

    public function traer_permisos()
    {
        $roles = Role::select(['id', 'display_name'])
            ->with(['perms' => function ($query) {
                $query->select(['id', 'display_name']);
            }])
            ->get();

        return response()->json(['roles' => $roles]);
    }
}
