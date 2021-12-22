<?php

namespace HelpDesk\Http\Controllers\Operador;

use Entrust;
use Carbon\Carbon;
use Illuminate\Http\Request;
use HelpDesk\Entities\Solicitude;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

/**
 * Administra las solicitudes por medio del operador
 */
class SolicitudesController extends Controller
{
    public function index(Request $request)
    {
        $userAuth = Auth::user();

        $verifyAccess =  (Entrust::hasRole(['admin']) || $userAuth->isOperador()) && $userAuth->can('solicitude_access');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.solicitudes.index', [
            'statuses'           => Status::pluck('display_name', 'id')->prepend('Todos',''),
            'departamentos'      => Departamento::pluck('nombre', 'id')->prepend('Todos',''),
        ]);
    }

    public function datatables(Request $request)
    {
        $query = Solicitude::query()->select('solicitudes.*')
            ->when($request->input('status'),function($q,$status){
                $q->where('estatus_id',$status);
            })
            ->when($request->input('departamento'),function($q,$departamento){
                $q->whereHas('empleado',function($q) use($departamento){
                    $q->where('departamento_id',$departamento);
                });
            })
            ->when($request->filled(['from','to']),function($q) use($request){
                $formatFrom = Carbon::parse($request->input('from'));
                $formatTo  = Carbon::parse($request->input('to'));

                $q->whereBetween('fecha',[$formatFrom,$formatTo]);
            })
            ->with('empleado.departamento','status');

        return DataTables::eloquent($query)
            ->editColumn('fecha',function($model){
                return $model->fecha->format('d/m/Y H:i a');
            })
            ->addColumn('label_status',function($model){
                return "<span class='badge badge-primary text-sm'style='background-color:{$model->status->color}'>{$model->status->display_name}</span>";
            })
            ->addColumn('buttons', 'operador.solicitudes.datatables._buttons')
            ->rawColumns(['buttons','label_status'])
            ->make(true);

    }

    public function edit(Solicitude $model)
    {
        $userAuth = Auth::user();

        $verifyAccess =  (Entrust::hasRole(['admin']) || $userAuth->isOperador()) && $userAuth->can('solicitude_edit');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->load('status');

        return view('operador.solicitudes.edit', [
            'model'     => $model,
            'statuses'  => Status::all()->pluck('display_name', 'id')->toArray()
        ]);
    }


    public function update(Request $request, Solicitude $model)
    {
        $userAuth = Auth::user();

        $verifyAccess =  (Entrust::hasRole(['admin']) || $userAuth->isOperador()) && $userAuth->can('solicitude_edit');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        DB::beginTransaction();


        try {
            if ($request->has('abrir-ticket')) {

                $ticket = $model->ticket()->create([
                    'fecha'         => now(),
                    'titulo'        => "Atentiendo Solicitud {$model->id}",
                    'incidente'     => $model->incidente,
                    'usuario_id'    => $model->usuario_id,
                    'estado'        => Config::get('helpdesk.tickets.estado.alias.ABT'),
                    'asignado_a'    => $userAuth->id,
                    'privado'       => 'N',
                    'operador_id'   => $userAuth->id,
                    'contacto'      => 'email',
                    'prioridad'     => 3,
                    'proceso'       => 'En Proceso',
                    'tipo'          => 'Personal',
                    'sub_tipo'      => '',
                ]);

                $model->ticket_id = $ticket->id;
                $model->estatus_id = optional(Status::proceso()->first())->id;
                $model->save();

                # CREATE ASIGN MODEL
                $ticket->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'asignado_a',
                    'valor_anterior'    => null,
                    'valor_actual'      => auth()->id(),
                    'comentario'        => '',
                    'privado'           => 'N',
                ]);

                DB::commit();

                return redirect()
                    ->route('operador.tickets.edit', $ticket)
                    ->with(['message' => 'Ticket Asignado correctamente']);
            }

            if ($request->has('cancelar-solicitud')) {

                $model->estatus_id = optional(Status::canceladas()->first())->id;
                $model->save();

                DB::commit();

                return redirect()
                    ->back()
                    ->with(['message' => 'Solicitud cancelada correctamente']);
            }

            # validar en caso de que las dos opciones fallen

        } catch (\Exception $e) {
            DB::rollback();

            return  redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }

    public function show(Solicitude $model)
    {
        $userAuth = Auth::user();

        $verifyAccess =  (Entrust::hasRole(['admin']) || $userAuth->isOperador()) && $userAuth->can('solicitude_show');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.solicitudes.show', compact('model'));
    }

    public function destroy(Solicitude $model)
    {
        $model->estatus_id = optional(Status::canceladas()->first())->id;
        $model->save();

        return back();
    }

    public function archivo(Solicitude $model)
    {
        $model->load('media');

        abort_if(empty($model->media), HTTPMessages::HTTP_FORBIDDEN, __('No se ha asignado ningun archivo'));

        $url = $model->media->buildMediaFilePath();

        return response()->download($url)->deleteFileAfterSend(true);
    }
}
