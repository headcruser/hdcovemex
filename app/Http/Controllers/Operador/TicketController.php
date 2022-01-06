<?php

namespace HelpDesk\Http\Controllers\Operador;

use Carbon\Carbon;
use Entrust;

use HelpDesk\Entities\Media;
use Illuminate\Http\Request;
use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Admin\User;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use HelpDesk\Entities\Config\Attribute;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Events\CommentOperatorEvent;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use HelpDesk\Http\Requests\Operador\Tickets\TicketCreateRequest;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $userAuth = auth()->user();

        $defaultOperator = (optional($userAuth)->isOperador()) ? $userAuth->id : null;
        $userOperator = $request->input('operator_id', $defaultOperator);

        $statusDefault = 'Abierto';

        return view('operador.tickets.index', [
            'procesos'      => config('helpdesk.tickets.proceso.values',[]),
            'operators'     => User::with(['operador'])->has('operador')->pluck('nombre', 'id'),
            'userOperator'  => $userOperator,
            'statusDefault' => $statusDefault
        ]);
    }

    public function datatables(Request $request)
    {
        $query = Ticket::query()
            ->when($request->input('operador_id'),function($q,$operador){
                $q->where('operador_id',$operador);
            })
            ->when($request->input('proceso'),function($q,$proceso){
                $q->byProcess($proceso);
            })
            ->when($request->filled(['from','to']),function($q) use($request){
                $formatFrom = Carbon::parse($request->input('from'));
                $formatTo  = Carbon::parse($request->input('to'));

                $q->whereBetween('created_at',[$formatFrom,$formatTo]);
            })
            ->with(['empleado', 'empleado.departamento', 'empleado.roles']);

        return DataTables::eloquent($query)
            ->addColumn('nombre_prioridad',function($model){
                return $model->nombrePrioridad;
            })
            ->editColumn('fecha',function($model){
                return $model->fecha->format('d/m/Y');
            })
            ->editColumn('proceso',function($model){
                return " <span class='badge badge-primary text-sm' style='background-color:{$model->color_proceso}' >{$model->proceso}</span>";
            })
            ->addColumn('buttons', 'operador.tickets.datatables._buttons')
            ->rawColumns(['buttons','proceso'])
            ->make(true);
    }

    public function show(Ticket $model)
    {
        $model->load(['sigoTicket' => function ($query) {
            $query->where('comentario', '!=', '');
        }]);

        return view('operador.tickets.show', compact('model'));
    }

    public function create()
    {
        abort_unless(Entrust::can('ticket_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.tickets.create', [
            'model'         => new Ticket,
            'prioridad'     => Config::get('helpdesk.tickets.prioridad.values', []),
            'contacto'      => Attribute::contact()->pluck('value', 'id'),
            'tipo_contacto' => Attribute::type()->pluck('value', 'id'),
            'actividad'     => collect()->prepend('Selecciona antes tipo Contacto', ''),
            'estados'       => Config::get('helpdesk.tickets.estado.names'),
            'asignado'      => User::withRoles('soporte', 'jefatura')->pluck('nombre', 'id'),
        ]);
    }

    public function store(TicketCreateRequest $request)
    {
        $user = Auth::user();

        $defaultData = [
            'fecha'         => now(),
            'usuario_id'    => $user->id,
            'operador_id'   => $user->id,
            'contacto'      => 'web',
            'proceso'       => Config::get('helpdesk.tickets.proceso.alias.EPS'),
            'estado'        => Config::get('helpdesk.tickets.estado.alias.ABT'),
        ];

        $modelData = array_merge([
            'titulo'        => "Ingresado por operador {$user->id}",
            'incidente'     => $request->input('incidente'),
            'archivo'       => 'nullable',
            'prioridad'     => $request->input('prioridad', '3'),
            'asignado_a'    => $request->input('asignado_a'),
            'contacto'      => $request->input('contacto'),
            'tipo'          => $request->input('tipo'), #ATENCION
            'sub_tipo'      => $request->input('sub_tipo'), #ACTIVIDAD
            'privado'       => $request->input('privado', 'N'), #VISIBILIDAD MENSAJES
        ], $defaultData);

        $file = $request->file('archivo');

        DB::beginTransaction();

        try {

            $ticket = Ticket::create($modelData);

            # ADJUNTAR ARCHIVO
            if (!empty($file)) {
                $media = Media::createMediaArray($file);
                $ticket->media()->create($media);
            }

            # CREAR SEGUIMIENTO
            if ($request->filled('comentario')) {
                $ticket->sigoTicket()->create([
                    'privado'           => $request->input('privado', 'N'),
                    'fecha'             => now(),
                    'operador_id'       => $user->id,
                    'comentario'        => $request->input('comentario'),
                ]);
            }

            $ticket->save();

            DB::commit();


        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()} ",])->withInput();
        }

        # AQUI ENVIAR NOTIFICACIONES AL RESPECTIVO USUARIO

        return redirect()
            ->route('operador.tickets.show', $ticket)
            ->withStatus("Ticket Creado correctamente");
    }

    public function edit(Ticket $model)
    {
        abort_unless(Entrust::can('ticket_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.tickets.edit', [
            'model'         => $model,
            'prioridad'     => Config::get('helpdesk.tickets.prioridad.values', []),
            'tipo_contacto' => Attribute::type()->pluck('value', 'id'),
            'actividad'     => Attribute::typeAttribute($model->tipo)->orderBy('value','desc')->pluck('value'),
            'estados'       => Config::get('helpdesk.tickets.estado.names'),
            'procesos'      => Attribute::process()->pluck('value')
        ]);
    }

    public function update(Request $request, Ticket $model)
    {
        if (!$request->has('privado')) {
            $request->request->add(['privado' => 'N']);
        }

        $originalTicketData = $model->getOriginal();
        $comment = null;

        DB::beginTransaction();

        try {
            $model->update($request->all());

            if ($model->solicitud()->exists()) {
                switch ($request->input('proceso')) {
                    case Config::get('helpdesk.tickets.proceso.alias.FIN'):
                        $model->solicitud()->update([
                            'estatus_id' => optional(Status::finalizadas()->first())->id
                        ]);
                        break;
                    case Config::get('helpdesk.tickets.proceso.alias.CAN'):
                        $model->solicitud()->update([
                            'estatus_id' => optional(Status::canceladas()->first())->id
                        ]);
                        break;
                }
            }

            if ($originalTicketData['prioridad'] !=  $request->input('prioridad')) {
                $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'prioridad',
                    'valor_anterior'    => $originalTicketData['prioridad'],
                    'valor_actual'      => $request->input('prioridad'),
                    'comentario'        => '',
                    'privado'           => $request->input('privado'),
                ]);
            }

            if ($originalTicketData['contacto'] !=  $request->input('contacto')) {
                $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'contacto',
                    'valor_anterior'    => $originalTicketData['contacto'],
                    'valor_actual'      => $request->input('contacto'),
                    'comentario'        => '',
                    'privado'           => $request->input('privado'),
                ]);
            }

            if ($originalTicketData['estado'] !=  $request->input('estado')) {
                $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'estado',
                    'valor_anterior'    => $originalTicketData['estado'],
                    'valor_actual'      => $request->input('estado'),
                    'comentario'        => '',
                    'privado'           => $request->input('privado'),
                ]);
            }

            if ($originalTicketData['proceso'] !=  $request->input('proceso')) {
                $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'proceso',
                    'valor_anterior'    => $originalTicketData['proceso'],
                    'valor_actual'      => $request->input('proceso'),
                    'comentario'        => '',
                    'privado'           => $request->input('privado'),
                ]);
            }

            if ($originalTicketData['tipo'] !=  $request->input('tipo')) {
                $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'tipo',
                    'valor_anterior'    => $originalTicketData['tipo'],
                    'valor_actual'      => $request->input('tipo'),
                    'comentario'        => '',
                    'privado'           => $request->input('privado'),
                ]);
            }

            if ($originalTicketData['sub_tipo'] !=  $request->input('sub_tipo')) {
                $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'sub_tipo',
                    'valor_anterior'    => $originalTicketData['sub_tipo'],
                    'valor_actual'      => $request->input('sub_tipo'),
                    'comentario'        => '',
                    'privado'           => $request->input('privado'),
                ]);
            }

            if ($request->filled('comentario')) {
                $comment = $model->sigoTicket()->create([
                    'fecha'             => now(),
                    'operador_id'       => auth()->id(),
                    'campo_cambiado'    => 'comentario',
                    'comentario'        => $request->input('comentario'),
                    'privado'           => $request->input('privado'),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return  redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }

        if ($request->filled('comentario')) {
            event(new CommentOperatorEvent($comment));
        }


        return redirect()
            ->route('operador.tickets.index')
            ->with(['message' => 'Ticket Actualizado correctamente']);
    }

    public function destroy(Ticket $model)
    {
        abort_unless(Entrust::can('ticket_delete'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->delete();

        return back();
    }

    public function storeComment(Request $request, Ticket $model)
    {
        $request->validate([
            'comentario_texto' => 'required'
        ]);

        $comment = null;
        $authUser = auth()->id();

        DB::beginTransaction();
        try {

            $comment = $model->sigoTicket()->create([
                'operador_id'   => $authUser,
                'fecha'         => now(),
                'comentario'    => $request->input('comentario_texto'),
                'privado'       => 'S',
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$ex->getMessage()} "])->withInput();
        }

        $model->refresh();

        event(new CommentOperatorEvent($comment));

        return redirect()
            ->back()
            ->with(['message' => 'Comentario agregado correctamente']);
    }

    public function finalizar_ticket(Ticket $ticket, Request $request)
    {
        $originalTicketData = $ticket->getOriginal();
        $comment = null;
        $now = now();
        $operador_id = auth()->id();

        DB::beginTransaction();

        try {
            $ticket->update([
                'proceso' => config('helpdesk.tickets.proceso.alias.FIN'),
                'estado'  => config('helpdesk.tickets.estado.alias.FIN'),
            ]);

            $ticket->sigoTicket()->create([
                'fecha'             => $now,
                'operador_id'       => $operador_id,
                'campo_cambiado'    => 'estado',
                'valor_anterior'    => $originalTicketData['estado'],
                'valor_actual'      => config('helpdesk.tickets.estado.alias.FIN'),
                'comentario'        => '',
                'privado'           => 'N',
            ]);

            $ticket->sigoTicket()->create([
                'fecha'             => $now,
                'operador_id'       => $operador_id,
                'campo_cambiado'    => 'proceso',
                'valor_anterior'    => $originalTicketData['proceso'],
                'valor_actual'      => config('helpdesk.tickets.proceso.alias.FIN'),
                'comentario'        => '',
                'privado'           => 'N',
            ]);

            if ($request->filled('comentario')) {
                $comment = $ticket->sigoTicket()->create([
                    'fecha'             => $now,
                    'operador_id'       => $operador_id,
                    'campo_cambiado'    => 'comentario',
                    'comentario'        => $request->input('comentario'),
                    'privado'           => 'N',
                ]);
            }

            $ticket->solicitud()->update([
                'estatus_id' => optional(Status::finalizadas()->first())->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success'   => false,
                'mesagge'   => 'Hubo un error al finalizar el ticket',
                'cause'     => $e->getMessage(),
            ],422);

        }

        // if ($request->filled('comentario')) {
        //     event(new CommentOperatorEvent($comment));
        // }

        return response()->json([
            'success' => true,
            'mesagge' => 'Ticket Finalizado corrrectamente',

        ]);
    }

    public function cancelar_ticket(Ticket $ticket, Request $request)
    {
        $originalTicketData = $ticket->getOriginal();
        $comment = null;
        $now = now();
        $operador_id = auth()->id();

        DB::beginTransaction();

        try {
            $ticket->update([
                'proceso' => config('helpdesk.tickets.proceso.alias.CAN'),
                'estado'  => config('helpdesk.tickets.estado.alias.CAN'),
            ]);

            $ticket->sigoTicket()->create([
                'fecha'             => $now,
                'operador_id'       => $operador_id,
                'campo_cambiado'    => 'estado',
                'valor_anterior'    => $originalTicketData['estado'],
                'valor_actual'      => config('helpdesk.tickets.estado.alias.CAN'),
                'comentario'        => '',
                'privado'           => 'N',
            ]);

            $ticket->sigoTicket()->create([
                'fecha'             => $now,
                'operador_id'       => $operador_id,
                'campo_cambiado'    => 'proceso',
                'valor_anterior'    => $originalTicketData['proceso'],
                'valor_actual'      => config('helpdesk.tickets.proceso.alias.CAN'),
                'comentario'        => '',
                'privado'           => 'N',
            ]);

            if ($request->filled('comentario')) {
                $comment = $ticket->sigoTicket()->create([
                    'fecha'             => $now,
                    'operador_id'       => $operador_id,
                    'campo_cambiado'    => 'comentario',
                    'comentario'        => $request->input('comentario'),
                    'privado'           => 'N',
                ]);
            }

            $ticket->solicitud()->update([
                'estatus_id' => optional(Status::canceladas()->first())->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success'   => false,
                'mesagge'   => 'Hubo un error al cancelar el ticket',
                'cause'     => $e->getMessage(),
            ],422);

        }

        // if ($request->filled('comentario')) {
        //     event(new CommentOperatorEvent($comment));
        // }

        return response()->json([
            'success' => true,
            'mesagge' => 'Ticket Cancelado correctamente',

        ]);
    }
}
