<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Inventario\ComponenteEquipo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use HelpDesk\Entities\Inventario\Equipo;
use HelpDesk\Entities\Inventario\EquipoAsignado;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;

class EquiposController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.equipos.index');
    }

    public function datatables(Request $request)
    {

        $query = Equipo::query()
            ->select('equipos.*')
            ->WithLastEquipo();

        return DataTables::of($query)
            ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['historial_asignaciones']);
        return view('gestion-inventarios.equipos.show',compact('equipo'));
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
            ->route('gestion-inventarios.equipos.show',$equipo)
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
            ->when($request->input('id_equipo'),function($q,$id_equipo){
                $q->where('id_equipo',$id_equipo);
            })
            ->with(['hardware']);

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons_detalle_equipo')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function buscar_componente_equipo(ComponenteEquipo $componenteEquipo)
    {
        $componenteEquipo->load(['equipo','hardware']);

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
        if (ComponenteEquipo::query()->where('id_hardware',$data['id_hardware'])->where('id_equipo',$data['id_equipo'])->exists()) {
            return response()->json([
                'success' => 'false' ,
                'error'   => 'Ya has agregado este hardware al equipo'
            ],422);
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
        ->when($request->input('id_equipo'),function($q,$id_equipo){
            $q->where('id_equipo',$id_equipo);
        })
        ->with(['personal.departamento','equipo']);

        return DataTables::eloquent($query)
            ->editColumn('observaciones',function($model){
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
            ->rawColumns(['observaciones','fecha_entrega'])
            ->make(true);
    }

    public function asignar_equipo(Request $request)
    {
        EquipoAsignado::create([
            'id_personal'   => $request->input('id_personal'),
            'fecha_entrega' => $request->input('fecha_entrega'),
            'id_equipo'     => $request->input('id_equipo'),
            'observaciones' => $request->input('observaciones'),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $request->all(),
            'message' => 'Equipo Asignado correctamente',
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

        return response()->json([
            'equipo' => $equipo
        ]);
    }
}
