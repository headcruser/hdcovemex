<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use HelpDesk\Entities\Admin\{Role, Permission};
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Http\Requests\Admin\Role\{CreateRoleRequest, UpdateRoleRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class RolesController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('role_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.roles.index');
    }


    public function datatables()
    {
        $query = Role::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'admin.roles.datatables._buttons')
            ->rawColumns(['buttons', 'roles'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('role_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.roles.create', [
            'model'     => new Role(),
            'permisos'  => Permission::all()->pluck('display_name', 'id')
        ]);
    }

    public function store(CreateRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $rol = Role::create($request->all());
            $rol->perms()->sync($request->input('permisos', []));

            DB::commit();

            return redirect()
                ->route('admin.roles.index')
                ->with(['message' => 'Rol Creado Correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function edit(Role $model)
    {
        abort_unless(Entrust::can('role_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.roles.edit', [
            'model'     => $model,
            'permisos'  => Permission::all()->pluck('display_name', 'id'),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $model)
    {
        DB::beginTransaction();
        try {

            $model->update($request->all());
            $model->perms()->sync($request->input('permisos', []));

            DB::commit();

            return  redirect()
                ->route('admin.roles.index')
                ->with(['message' => 'Rol actualizado correctamento']);
        } catch (\Exception $e) {
            DB::rollback();

            return  redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function show(Role $model)
    {
        abort_unless(Entrust::can('role_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.roles.show', ['model' => $model]);
    }

    public function destroy(Request $request, Role $model)
    {
        $model->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El rol se eliminó con éxito",
            ]);
        }

        return back()->with([
            'message' => "El rol se eliminó con éxito"
        ]);
    }

    public function massDestroy(Request $request)
    {
        Role::whereIn('id', $request->input('ids'))->delete();

        return response(null, HTTPMessages::HTTP_NO_CONTENT);
    }
}
