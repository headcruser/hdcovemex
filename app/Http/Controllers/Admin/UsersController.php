<?php

namespace HelpDesk\Http\Controllers\Admin;

use HelpDesk\Entities\Admin\{Role, User, Departamento};
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Http\Requests\Admin\User\{CreateUserRequest, UpdateUserRequest};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with(['departamento', 'roles'])->paginate();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('name', 'id');
        $departamentos = Departamento::all()->pluck('nombre', 'id')->prepend('Selecciona un departamento', '');
        $user = new User();

        return view('admin.users.create', compact('roles', 'departamentos', 'user'));
    }

    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));

            DB::commit();

            return redirect()->route('admin.usuarios.index')
                ->with([
                    'message' => 'Usuario Creado Correctamente'
                ]);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all()->pluck('name', 'id');
        $departamentos = Departamento::all()->pluck('nombre', 'id')->prepend('Selecciona un departamento', '');

        return view('admin.users.edit', compact('roles', 'user', 'departamentos'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->update($request->all());
            $user->roles()->sync($request->input('roles', []));
            DB::commit();

            return redirect()->route('admin.usuarios.index');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function show(User $user)
    {
        $user->load(['roles', 'departamento']);

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', $request->input('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
