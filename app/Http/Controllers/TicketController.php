<?php

namespace HelpDesk\Http\Controllers;

use Entrust;
use Illuminate\Http\Request;
use HelpDesk\Entities\Ticket;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use Illuminate\Support\Facades\Cache;

class TicketController extends Controller
{
     /**
     * List Resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Entrust::can('ticket_access'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('tickets.index', ['collection' => Ticket::with(['usuario','usuario.departamento','usuario.roles'])->paginate()]);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $model)
    {
        abort_unless(Entrust::can('ticket_show'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('tickets.show', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Entrust::can('ticket_create'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'        => 'required',
            'incidente'     => 'required',
        ]);

        // $request->request->add([
        //     'fecha'         => now(),
        //     'usuario_id'   => auth()->id(),
        //     'estatus_id'    => optional(Status::where('name', 'PEN')->first())->id
        // ]);

        // $file = $request->file('archivo');

        // if (!empty($file)) {
        //     $request->request->add([
        //         'tipo_adjunto'      => $file->getMimeType(),
        //         'nombre_adjunto'    => $file->getClientOriginalName(),
        //         'adjunto'           => file_get_contents($file),
        //     ]);
        // }

        DB::beginTransaction();
        try {
            $ticket = Ticket::create($request->all());

            DB::commit();

            return redirect()
                ->route('tickets.show', $ticket)
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
        abort_unless(Entrust::can('ticket_edit'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('tickets.edit', [
            'model' => $model
        ]);
    }


    public function update(Request $request, Ticket $model)
    {
        DB::beginTransaction();

        try {

            $model->update($request->all());


            DB::commit();

            return  redirect()
                ->route('tickets.index')
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
        abort_unless(Entrust::can('ticket_delete'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

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
