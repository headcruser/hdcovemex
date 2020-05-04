<?php

namespace HelpDesk\Http\Controllers\Operador;

use Entrust;

use HelpDesk\Entities\Media;
use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Config\Attribute;
use HelpDesk\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class TicketController extends Controller
{
    /**
     * List Resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Entrust::can('ticket_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $tickets = Ticket::assingTo($request->input('operator_id'))
            ->with(['empleado', 'empleado.departamento', 'empleado.roles'])
            ->search($request->input('search'))
            ->byStatus($request->input('status'))
            ->orderByDesc('created_at')
            ->paginate();


        $tickets->appends([
            'status'    => $request->input('status'),
            'search'    => $request->input('search'),
        ]);

        return view('operador.tickets.index', [
            'collection'    => $tickets,
            'statuses'      => Config::get('helpdesk.tickets.estado.names', []),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $model)
    {
        abort_unless(Entrust::can('ticket_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.tickets.show', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Entrust::can('ticket_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.tickets.create',[
            'model'         => new Ticket,
            'prioridad'     => Config::get('helpdesk.tickets.prioridad.values', []),
            'contacto'      => Attribute::contact()->pluck('value','id'),
            'tipo_contacto' => Attribute::type()->pluck('value','id'),
            'actividad'     => collect()->prepend('Selecciona antes tipo Contacto', ''),
            'estados'       => Config::get('helpdesk.tickets.estado.names'),
            'asignado'      => User::withRoles('soporte','jefatura')->pluck('nombre','id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'titulo'        => 'required',
            'incidente'     => 'required',
            'archivo'       => 'nullable',
            'prioridad'     => '',
            'estado'        => '',
            'asignado_a'    => '',
            'contacto'      => '',
            'tipo'          => '', #ATENCION
            'sub_tipo'       => '', #ACTIVIDAD
            'privado'       => '', #VISIBILIDAD MENSAJES
        ]);

        $defaultData = [
            'fecha'         => now(),
            'usuario_id'    => $user->id,
            'operador_id'   => $user->id,
            'contacto'      => 'email',
            'proceso'       => Config::get('helpdesk.tickets.proceso.alias.EPS'),
        ];

        $modelData = array_merge($validated,$defaultData);
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
            $ticket->sigoTicket()->create([
                'operador_id'   => $user->id,
                'usuario_id'    => null,
                'fecha'         => now(),
                'comentario'    => '',
                'visible'       => 'S',
            ]);

            $ticket->save();

            DB::commit();

            return redirect()
                ->route('operador.tickets.show', $ticket)
                ->withStatus("Ticket Creado correctamente");
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()} ",])->withInput();
        }
    }

    public function edit(Ticket $model)
    {
        abort_unless(Entrust::can('ticket_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.tickets.edit', [
            'model'         => $model,
            'prioridad'     => Config::get('helpdesk.tickets.prioridad.values', []),
            'tipo_contacto' => Config::get('helpdesk.tickets.contacto.values', []),
            'actividad'     => collect()->prepend('Selecciona un vehiculo', ''),
            'estados'       => Config::get('helpdesk.tickets.estado.names'),
        ]);
    }

    public function update(Request $request, Ticket $model)
    {
        if (!$request->has('privado')) {
            $request->request->add(['privado'=> 'N']);
        }

        DB::beginTransaction();

        try {

            # ACTUALIZAR INFORMACION DEL TICKET
            $model->update($request->all());

            # VERIFICAR SI EXISTE UNA SOLICITUD PARA FINALIZAR LA MISMA SOLICITUD
            $solicitud = $model->solicitud;

            if ($solicitud) {
                #$solicitud->update;

                switch ($request->input('estado')) {
                    case 'Finalizado':
                        $solicitud->update([
                            'estatus_id' => '3'
                        ]);
                        break;
                    case 'Cancelado':
                        $solicitud->update([
                            'estatus_id' => '4'
                        ]);
                        break;
                }
            }

            DB::commit();

            return redirect()
                ->route('operador.tickets.index')
                ->with(['message' => 'Ticket Actualizado correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return  redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
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

        DB::beginTransaction();
        try {

            $comment = $model->sigoTicket()->create([
                'operador_id'   => auth()->id(),
                'fecha'         => now(),
                'comentario'    => $request->input('comentario_texto'),
                'visible'       => 'S',
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$ex->getMessage()} "])->withInput();
        }

        # $model->sendCommentNotification($comment);

        return redirect()
            ->back()
            ->with(['message' => 'Comentario agregado correctamente']);
    }
}
