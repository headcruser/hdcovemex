<?php

namespace HelpDesk\Http\Controllers\Admin;

use HelpDesk\Entities\Admin\{Role, User, Departamento};
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Http\Requests\Admin\User\{CreateUserRequest, UpdateUserRequest};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpFoundation\Response;
use Entrust;

class UsersController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.index', [ 'collection' => User::with(['departamento', 'roles'])->paginate() ]);
    }

    public function create()
    {
        abort_unless(Entrust::can('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.create', [
            'roles'         => Role::all()->pluck('name', 'id'),
            'departamentos' => Departamento::all()->pluck('nombre', 'id')->prepend('Selecciona un departamento', ''),
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
        abort_unless(Entrust::can('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->load('roles');

        return view('admin.users.edit', [
            'roles'         => Role::all()->pluck('name', 'id'),
            'departamentos' => Departamento::all()->pluck('nombre', 'id')->prepend('Selecciona un departamento', ''),
            'model'         => $model
        ]);
    }

    public function update(UpdateUserRequest $request, User $model)
    {
        DB::beginTransaction();
        try {
            $model->update($request->all());
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
        abort_unless(Entrust::can('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->load(['roles', 'departamento']);

        return view('admin.users.show', ['model' => $model]);
    }

    public function destroy(User $model)
    {
        abort_unless(Entrust::can('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', $request->input('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
