<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use HelpDesk\Entities\Admin\{Role, Permission};
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Http\Requests\Admin\Role\{CreateRoleRequest, UpdateRoleRequest};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::paginate();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_unless(Entrust::can('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rol = new Role();
        $permisos = Permission::all()->pluck('display_name', 'id');

        return view('admin.roles.create', compact('rol', 'permisos'));
    }

    public function store(CreateRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $rol = Role::create($request->all());
            $rol->perms()->sync($request->input('permisos', []));

            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with([
                    'message' => 'Rol Creado Correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function edit(Role $rol)
    {
        abort_unless(Entrust::can('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permisos = Permission::all()->pluck('display_name', 'id');
        return view('admin.roles.edit', compact('rol', 'permisos'));
    }

    public function update(UpdateRoleRequest $request, Role $rol)
    {
        DB::beginTransaction();
        try {

            $rol->update($request->all());
            $rol->perms()->sync($request->input('permisos', []));
            DB::commit();

            return  redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            DB::rollback();

            return  redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function show(Role $rol)
    {
        abort_unless(Entrust::can('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.roles.show', compact('rol'));
    }

    public function destroy(Role $rol)
    {
        abort_unless(Entrust::can('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rol->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Role::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
