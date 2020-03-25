<?php

namespace HelpDesk\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Admin\Permission;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use HelpDesk\Http\Requests\Admin\Permisos\CreatePermisoRequest;
use HelpDesk\Http\Requests\Admin\Permisos\UpdatePermisoRequest;

class PermisosController extends Controller
{
    public function index()
    {
        $permisos = Permission::paginate();
        return view('admin.permisos.index', compact('permisos'));
    }

    public function create()
    {
        $permiso = new Permission();
        return view('admin.permisos.create', compact('permiso'));
    }

    public function store(CreatePermisoRequest $request)
    {
        DB::beginTransaction();
        try {
            $permiso = Permission::create($request->all());
            DB::commit();

            return redirect()->route('admin.permisos.index')
            ->with([
                'message' => 'Permiso Creado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
            ->with([
                'error' => 'Error Servidor; ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function edit(Permission $permiso)
    {
        return view('admin.permisos.edit', compact('permiso'));
    }

    public function update(UpdatePermisoRequest $request, Permission $permiso)
    {
        DB::beginTransaction();
        try {

            $permiso->update($request->all());
            DB::commit();

            return  redirect()->route('admin.permisos.index')->with([
                'message' => 'Permiso actualizado correctamente'
            ]);

        }catch(\Exception $e){
            DB::rollback();

            return redirect()->back()
            ->with([
                'error' => 'Error Servidor; ' . $e->getMessage(),
            ])->withInput();
        }

    }

    public function show(Permission $permiso)
    {
        return view('admin.permisos.show', compact('permiso'));
    }

    public function destroy(Permission $permiso)
    {
        $permiso->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Permission::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
