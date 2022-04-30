<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use HelpDesk\Entities\Inventario\Equipo;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Inventario\EquipoAsignado;
use HelpDesk\Entities\Inventario\ComponenteEquipo;

class EquiposController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.equipos.index',[
            'estatus'   => ['' => 'Todos'] + config('gestion-inventarios.equipos.status.values', []),
            'tipo'      => ['' => 'Todos'] + config('gestion-inventarios.equipos.tipo.values', []),
        ]);
    }

    public function datatables(Request $request)
    {
        $sub = Equipo::query()
            ->select(['id', 'uid', 'descripcion','status','tipo'])
            ->WithLastEquipo();

        $query = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->when($request->input('status'), function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->input('tipo'), function ($q, $status) {
                $q->where('tipo', $status);
            });

        $estatus = config('gestion-inventarios.equipos.status.class', []);

        return DataTables::of($query)
            ->editColumn('status',function($model)use($estatus){
                $class = $estatus[trim($model->status)] ?? 'badge bg-default';

                return "<span class='{$class}'>{$model->status}</span>";
            })
            ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons')
            ->rawColumns(['status','buttons'])
            ->make(true);
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['historial_asignaciones']);

        $estatus = config('gestion-inventarios.equipos.status.values', []);
        $tipo =  config('gestion-inventarios.equipos.tipo.values', []);

        return view('gestion-inventarios.equipos.show', compact('equipo','estatus','tipo'));
    }

    public function create()
    {
        $equipo = new Equipo();
        $equipo->fill([
            'descripcion'   => '',
            'fecha_equipo'  => now(),
            'uid'           => Str::uuid()
        ]);

        $equipo->save();

        return redirect()
            ->route('gestion-inventarios.equipos.show', $equipo)
            ->with(['message' => 'Equipo agregado correctamente']);
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $equipo->fill($request->except('_token'));
        $equipo->save();

        return redirect()
            ->route('gestion-inventarios.equipos.show', $equipo)
            ->with(['message' => 'Equipo editado correctamente']);
    }

    public function destroy(Equipo $equipo, Request $request)
    {
        $equipo->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'equipo eliminado correctamente'
            ], 200);
        }

        return redirect()
            ->route('gestion-inventarios.equipos.index')
            ->with(['message' => 'Equipo eliminado correctamente']);
    }

    public function select2(Request $request)
    {
        $term  = $request->input('term');
        $page = $request->input('page');
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $results = Equipo::query()
            ->where('descripcion', 'like', '%' . $term . '%')
            ->orderBy('descripcion')
            ->skip($offset)
            ->take($resultCount)->get();

        $count = Equipo::query()
            ->where('descripcion', 'like', '%' . $term . '%')
            ->count();

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        return response()->json([
            "results" => $results,
            "pagination" => [
                "more" => $morePages
            ]
        ]);
    }

    public function datatables_componentes_equipo(Request $request)
    {
        $query = ComponenteEquipo::query()
            ->when($request->input('id_equipo'), function ($q, $id_equipo) {
                $q->where('id_equipo', $id_equipo);
            })
            ->with(['hardware']);

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons_detalle_equipo')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function buscar_componente_equipo(ComponenteEquipo $componenteEquipo)
    {
        $componenteEquipo->load(['equipo', 'hardware']);

        return response()->json([
            'success' => true,
            'data'    => $componenteEquipo
        ]);
    }

    public function agregar_componente_equipo(Request $request)
    {
        $data = $request->validate([
            'id_hardware'   => 'required',
            'id_equipo'     => 'required',
            'observacion'   => 'nullable',
        ]);

        # FIXME: VERIFICAR SI EL HARDWARE YA HA SIDO ASIGNADO A OTRO EQUIPO
        if (ComponenteEquipo::query()->where('id_hardware', $data['id_hardware'])->where('id_equipo', $data['id_equipo'])->exists()) {
            return response()->json([
                'success' => 'false',
                'error'   => 'Ya has agregado este hardware al equipo'
            ], 422);
        }


        $componenteEquipo = ComponenteEquipo::create($data);

        $componenteEquipo->hardware()->update(['asignado' => true]);


        return response()->json([
            'success' => 'true',
            'message' => 'agregar_componente_equipo',
        ]);
    }

    public function actualizar_componente_equipo(Request $request, ComponenteEquipo $componenteEquipo)
    {
        $data = $request->validate([
            'id_hardware'   => 'required',
            'id_equipo'     => 'required',
            'observacion'   => 'nullable',
        ]);

        $componenteEquipo->fill($data);

        $componenteEquipo->save();

        return response()->json([
            'success' => true,
            'message' => 'Componente actualizado correctamente',
            'data'    => $componenteEquipo
        ]);
    }

    public function eliminar_componente_equipo(ComponenteEquipo $componenteEquipo)
    {
        $componenteEquipo->hardware()->update([
            'asignado' => false
        ]);

        $componenteEquipo->delete();

        return response()->json([
            'message' => 'componente eliminado correctamente'
        ], 200);
    }

    public function datatables_asignar_equipo(Request $request)
    {
        $query = EquipoAsignado::query()->select('equipo_asignado.*')
            ->when($request->input('id_equipo'), function ($q, $id_equipo) {
                $q->where('id_equipo', $id_equipo);
            })
            ->with(['personal.departamento', 'equipo']);

        return DataTables::eloquent($query)
            ->editColumn('personal.nombre', function ($model) {
                $route = route('gestion-inventarios.personal.show',$model->id_personal);
                return "<a class='btn-link'
                            href='{$route}'> {$model->personal->nombre} </a>";
            })
            ->editColumn('observaciones', function ($model) {
                $route = route('gestion-inventarios.equipos.actualizar_asignacion_equipo');

                return "<a class='editable_observaciones_equipo_asignado'
                    data-name='observaciones'
                    data-type='textarea'
                    data-placement='left'
                    data-value='{$model->observaciones}'
                    data-pk='{$model->id}'
                    data-url='{$route}'
                    data-placeholder='Observaciones'> {$model->observaciones} </a>";
            })
            ->editColumn('fecha_entrega', function ($model) {
                $route = route('gestion-inventarios.equipos.actualizar_asignacion_equipo');
                $valor = optional($model->fecha_entrega)->format('Y-m-d');
                $text = optional($model->fecha_entrega)->format('d-m-Y');

                return "<a class='editable_fecha_entrega_equipo_asignado'
                    data-name='fecha_entrega'
                    data-type='date'
                    data-placement='top'
                    data-value='{$valor}'
                    data-pk='{$model->id}'
                    data-url='{$route}'
                    data-placeholder='Fecha entrega'>{$text}</a>";
            })
            ->editColumn('status', function ($model) {
                $route = route('gestion-inventarios.equipos.actualizar_asignacion_equipo');

                return "<a class='editable_status_equipo_asignado'
                    data-name='status'
                    data-type='select'
                    data-placement='left'
                    data-value='{$model->status}'
                    data-pk='{$model->id}'
                    data-url='{$route}'
                    data-placeholder='Status'> {$model->status} </a>";
            })
            ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons_asignacion_equipo')
            ->rawColumns(['personal.nombre','observaciones', 'fecha_entrega','status', 'buttons'])
            ->make(true);
    }

    public function asignar_equipo(Request $request)
    {
        $request->validate([
            'id_personal' => 'required',
        ]);

        $equipoAsignado = new EquipoAsignado();

        $equipoAsignado->fill($request->except('_token','carta_responsiva'));

        if ($request->hasFile('carta_responsiva')) {
            $file = $request->file('carta_responsiva');
            $url_archivo = $file->storeAs("cartas_responsivas/{$equipoAsignado->id}", $file->getClientOriginalName(), 'public');
            $equipoAsignado->carta_responsiva = $url_archivo;
        }

        $equipoAsignado->save();

        return response()->json([
            'success' => true,
            'message' => 'Equipo Asignado correctamente',
        ]);
    }

    public function editar_asignar_equipo(EquipoAsignado $equipoAsignado, Request $request)
    {
        $request->validate([
            'id_personal' => 'required',
        ]);

        $equipoAsignado->fill($request->except('_token','carta_responsiva'));

        if ($request->hasFile('carta_responsiva')) {
            $file = $request->file('carta_responsiva');
            $url_archivo = $file->storeAs("cartas_responsivas/{$equipoAsignado->id}", $file->getClientOriginalName(), 'public');
            $equipoAsignado->carta_responsiva = $url_archivo;
        }

        $equipoAsignado->save();

        return response()->json([
            'success' => true,
            'data'    => $request->all(),
            'message' => 'Asignacion actualizada correctamente',
        ]);
    }

    public function eliminar_asignar_equipo(EquipoAsignado $equipoAsignado, Request $request)
    {
        $equipoAsignado->delete();

        # 👉 ELIMINO EL ARCHIVO ANTEIROR
        if (!empty($equipoAsignado->carta_responsiva)) {
            Storage::disk('public')->delete($equipoAsignado->carta_responsiva);
        }

        return response()->json([
            'success' => true,
            'data'    => $request->all(),
            'message' => 'Asignacion eliminada correctamente',
        ]);
    }

    public function actualizar_informacion(Request $request)
    {
        $equipo = Equipo::find($request->pk);
        $equipo[$request->name] = $request->value;
        $equipo->save();

        return response()->json([
            'equipo' => $equipo
        ]);
    }

    public function actualizar_asignacion_equipo(Request $request)
    {
        $equipo = EquipoAsignado::findOrFail($request->pk);
        $equipo[$request->name] = $request->value;
        $equipo->save();

        $equipo->load('personal');

        return response()->json([
            'equipo' => $equipo
        ]);
    }
}
