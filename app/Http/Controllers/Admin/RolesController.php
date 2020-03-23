<?php

namespace HelpDesk\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\Role;
use Illuminate\Support\Facades\DB;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use HelpDesk\Http\Requests\Admin\Role\CreateRoleRequest;
use HelpDesk\Http\Requests\Admin\Role\UpdateRoleRequest;

class RolesController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::paginate();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        #abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rol = new Role();
        return view('admin.roles.create', compact('rol'));
    }

    public function store(CreateRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create($request->all());
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
        #abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.roles.edit', compact('rol'));
    }

    public function update(UpdateRoleRequest $request, Role $rol)
    {
        DB::beginTransaction();
        try {

            $rol->update($request->all());
            DB::commit();

            return  redirect()->route('admin.roles.index');
        }catch(\Exception $e){
            DB::rollback();

            return  redirect()->back()
            ->with([
                'error' => 'Error Servidor; ' . $e->getMessage(),
            ])->withInput();
        }

    }

    public function show(Role $rol)
    {
        // abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        return view('admin.roles.show', compact('rol'));
    }

    public function destroy(Role $rol)
    {
        #abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rol->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Role::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
