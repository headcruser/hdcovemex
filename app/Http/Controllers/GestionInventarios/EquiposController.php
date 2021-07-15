<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Inventario\ComponenteEquipo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use HelpDesk\Entities\Inventario\Equipo;
use HelpDesk\Entities\Inventario\EquipoAsignado;
use HelpDesk\Entities\Inventario\Hardware;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class EquiposController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.equipos.index');
    }

    public function datatables()
    {
        $query = Equipo::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons')
            ->editColumn('fecha_equipo',function($model){
                return $model->fecha_equipo->format('d-m-Y');
            })
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
        return view('gestion-inventarios.equipos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $equipo = new Equipo();
        $equipo->fill([
            'descripcion'   => $request->input('descripcion'),
            'fecha_equipo'  => Carbon::parse($request->input('fecha_equipo')),
            'uid'           => Str::uuid()
        ]);
        $equipo->save();


        return redirect()
            ->route('gestion-inventarios.equipos.show',$equipo)
            ->with(['message' => 'Eqiipo agregado correctamente']);
    }

    public function edit(Equipo $equipo)
    {
        return view('gestion-inventarios.equipos.edit',compact('equipo'));
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
        $query = EquipoAsignado::query()
        ->when($request->input('id_equipo'),function($q,$id_equipo){
            $q->where('id_equipo',$id_equipo);
        })
        ->with(['personal.departamento','equipo']);

        return DataTables::eloquent($query)
            ->editColumn('fecha_entrega',function($model){
                return $model->fecha_entrega->format('d-m-Y');
            })
            // ->addColumn('buttons', 'gestion-inventarios.equipos.datatables._buttons_detalle_equipo')
            // ->rawColumns(['buttons'])
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
}
