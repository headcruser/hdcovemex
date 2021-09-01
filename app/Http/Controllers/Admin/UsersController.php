<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Notifications\DatosAcceso;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Admin\{Role, User, Departamento};

use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use HelpDesk\Http\Requests\Admin\User\{CreateUserRequest, UpdateUserRequest};
use HelpDesk\Imports\UsuarioImport;
use Maatwebsite\Excel\Validators\ValidationException;

class UsersController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('user_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.users.index');
    }

    public function datatables()
    {
        $query = User::query()->whereHas('roles',function($q){
            $q->whereIn('name',['empleado']);
        })->with(['roles.perms','departamento']);

        return DataTables::eloquent($query)
            ->addColumn('roles',function($model){
                $span = '<span class="badge badge-warning"> Sin Roles</span>';

                if ($model->roles->isNotEmpty()) {
                    $span = '<span class="badge badge-info">'.$model->roles->pluck('display_name')->implode(',') .'</span>';
                }

                return $span;
            })
            ->addColumn('buttons', 'admin.users.datatables._buttons')
            ->rawColumns(['buttons','roles'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('user_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.users.create', [
            'roles'         => Role::query()->whereIn('name',['empleado'])->pluck('name', 'id'),
            'departamentos' => Departamento::query()->pluck('nombre', 'id')->prepend('Selecciona un departamento', ''),
            'model'          => new User()
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));
            DB::commit();

            # TODO Envio de correo al usuario
            if ($request->filled('enviar_datos')) {
                $user->notify(new DatosAcceso($request->password));
            }

            return redirect()->route('admin.usuarios.index')
                ->with(['message' => 'Usuario Creado Correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor:{$e->getMessage()}",])
                ->withInput();
        }
    }

    public function edit(User $model)
    {
        abort_unless(Entrust::can('user_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->load('roles');

        return view('admin.users.edit', [
            'roles'         => Role::query()->whereIn('name',['empleado']),
            'departamentos' => Departamento::query()->pluck('nombre', 'id')->prepend('Selecciona un departamento', ''),
            'model'         => $model
        ]);
    }

    public function update(UpdateUserRequest $request, User $model)
    {
        DB::beginTransaction();
        try {

            $model->nombre  = $request->input('nombre');
            $model->email = $request->input('email');
            $model->telefono = $request->input('telefono');

            if (!empty($request->input('password'))) {
                $model->password = $request->input('password');
            }

            $model->departamento_id = $request->input('departamento_id');
            $model->usuario = $request->input('usuario');
            $model->save();

            $model->roles()->sync($request->input('roles', []));

            DB::commit();

            return redirect()
                ->route('admin.usuarios.index')
                ->with(['message' => 'Usuario actualizado correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()}"])
                ->withInput();
        }
    }

    public function show(User $model)
    {
        abort_unless(Entrust::can('user_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->load(['roles', 'departamento']);

        return view('admin.users.show', ['model' => $model]);
    }

    public function destroy(User $model,Request $request)
    {
        $model->roles()->sync([]);
        $model->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El usuario se eliminó con éxito",
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Usuario Eliminado Correctamente'
        ]);
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', $request->input('ids'))->delete();
        return response(null, HTTPMessages::HTTP_NO_CONTENT);
    }

    public function importar(Request $request)
    {
        $this->validate($request, [
            'usuario' => 'required|mimes:xls,xlsx'
        ]);

        $archivo = $request->file('usuario');

         try {
            DB::beginTransaction();

            $import = new UsuarioImport;
            $import->import($archivo);

            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Usuarios Importados correctamente',
            ]);
        } catch (ValidationException $e) {
            DB::rollback();
            $failures = $e->failures();

            return response()->json([
                'success'   => false,
                'error'     => 'Error al importar los usuarios',
                'details'   => optional($failures[0])->errors()
            ],HTTPMessages::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
