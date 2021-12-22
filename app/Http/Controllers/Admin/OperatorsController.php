<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Admin\{Role,User,Operador,Departamento};
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use HelpDesk\Http\Requests\Admin\Operators\{CreateOperatorRequest,UpdateOperatorRequest};


class OperatorsController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('operator_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.operators.index');
    }

    public function datatables()
    {
        $query = Operador::query()->with(['usuario.roles']);

        return DataTables::eloquent($query)
            ->addColumn('roles',function($model){
                $span = '<span class="badge badge-warning"> Sin Roles</span>';

                if ($model->usuario->roles->isNotEmpty()) {
                    $span = '<span class="badge badge-info">'.$model->usuario->roles->pluck('display_name')->implode(',') .'</span>';
                }

                return $span;
            })
            ->addColumn('solicitud',function($model){
                return $model->notificar_solicitud_icon;
            })

            ->addColumn('asignacion',function($model){
                return $model->notificar_asignacion_icon;
            })
            ->addColumn('buttons', 'admin.operators.datatables._buttons')
            ->rawColumns(['buttons','roles','solicitud','asignacion'])
            ->make(true);

    }

    public function create(){
        abort_unless(Entrust::can('operator_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $roles = Role::query()
            ->select(['name','id'])
            ->whereNotIn('name', ['empleado'])
            ->pluck('name', 'id');

        $departamentos = Departamento::query()
            ->select(['id','nombre'])
            ->pluck('nombre', 'id')
            ->prepend('Selecciona un departamento', '');


        return view('admin.operators.create', [
            'roles'         => $roles,
            'departamentos' => $departamentos,
            'model'          => (new Operador())
        ]);
    }

    public function store(CreateOperatorRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));


            $user->operador()->create([
                'notificar_solicitud'   => $request->has('notificar_solicitud'),
                'notificar_asignacion'  => $request->has('notificar_asignacion'),
            ]);

            DB::commit();

            return redirect()->route('admin.operadores.index')
                ->with(['message' => 'Operador Creado Correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor:{$e->getMessage()}",])
                ->withInput();
        }
    }

    public function edit(Operador $operador)
    {
        abort_unless(Entrust::can('operator_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden') );

        $operador->load(['usuario','usuario.roles','usuario.media']);

        $roles = Role::query()
            ->select(['name','id'])
            ->whereNotIn('name', ['empleado'])
            ->pluck('name', 'id');

        $departamentos = Departamento::query()
            ->select(['id','nombre'])
            ->pluck('nombre', 'id')
            ->prepend('Selecciona un departamento', '');

        return view('admin.operators.edit', [
            'roles'         => $roles,
            'departamentos' => $departamentos,
            'model'         => $operador
        ]);
    }

    public function update(UpdateOperatorRequest $request, Operador $operador)
    {
        try {
            $usuario = $operador->usuario;

            $usuario->update($request->all());
            $usuario->roles()->sync($request->input('roles', []));

            $operador->update([
                'notificar_solicitud'   => $request->has('notificar_solicitud'),
                'notificar_asignacion'  => $request->has('notificar_asignacion'),
            ]);

            $operador->usuario()->associate($usuario);

            DB::commit();

            return redirect()
                ->route('admin.operadores.index')
                ->with(['message' => 'Operador actualizado correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()}"])
                ->withInput();
        }
    }

    public function show(Operador $operador)
    {
        abort_unless(Entrust::can('operator_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $operador->load(['usuario','usuario.roles', 'usuario.departamento']);

        return view('admin.operators.show', [ 'model' => $operador ]);
    }

    public function destroy(Request $request ,Operador $operador)
    {
        $operador->usuario->roles()->sync([]);
        $operador->usuario->deleted_at = now();
        $operador->usuario->save();
        $operador->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El operador se eliminó con éxito",
            ]);
        }

        return redirect()->back()->with([
            'message'   => "El operador se eliminó con éxito",
        ]);
    }
}
