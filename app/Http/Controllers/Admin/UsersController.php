<?php

namespace HelpDesk\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Admin\{Role, User};
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use HelpDesk\Http\Requests\Admin\User\{CreateUserRequest, UpdateUserRequest};


class UsersController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::with(['departamento','roles'])->paginate();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        #abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('nombre', 'id');
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
        #abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('nombre', 'id');
        $departamentos = Departamento::all()->pluck('nombre', 'id')->prepend('Selecciona un departamento', '');
        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user', 'departamentos'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {

            $user->update($request->all());
            $user->roles()->sync($request->input('roles', []));
            DB::commit();

            return  redirect()->route('admin.usuarios.index');
        }catch(\Exception $e){
            DB::rollback();

            return  redirect()->back()
            ->with([
                'error' => 'Error Servidor; ' . $e->getMessage(),
            ])->withInput();
        }

    }

    public function show(User $user)
    {
        // abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load(['roles', 'departamento']);

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        #abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
