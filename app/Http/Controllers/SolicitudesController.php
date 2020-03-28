<?php

namespace HelpDesk\Http\Controllers;

use Illuminate\Http\Request;
use HelpDesk\Entities\Solicitude;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use Entrust;

class SolicitudesController extends Controller
{
    /**
     * List Resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Entrust::can('solicitude_access'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('solicitudes.index', ['collection' => Solicitude::auth()->with(['status', 'empleado', 'empleado.departamento'])->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Entrust::can('solicitude_create'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('solicitudes.create');
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

        $request->request->add([
            'fecha'         => now(),
            'empleado_id'   => auth()->id(),
            'estatus_id'    => optional(Status::where('name', 'PEN')->first())->id
        ]);

        $file = $request->file('archivo');

        if (!empty($file)) {
            $request->request->add([
                'tipo_adjunto'      => $file->getMimeType(),
                'nombre_adjunto'    => $file->getClientOriginalName(),
                'adjunto'           => file_get_contents($file),
            ]);
        }

        DB::beginTransaction();
        try {
            $solicitud = Solicitude::create($request->all());

            DB::commit();

            return redirect()
                ->route('solicitudes.show', $solicitud)
                ->withStatus("Tu solicitud ha sido enviada. Te atenderemos a la brevedad posible");

        } catch (\Exception $e) {
            DB::rollback();
            #dd($e->getMessage());
            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()} ",])->withInput();
        }
    }

    public function edit(Solicitude $model)
    {
        abort_unless(Entrust::can('solicitude_edit'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('solicitudes.edit', [
            'model'     => $model,
            'statuses'  => Status::all()->pluck('display_name', 'id')->toArray()
        ]);
    }

    public function update(Request $request, Solicitude $model)
    {
        DB::beginTransaction();

        try {

            $model->update($request->all());

            DB::commit();

            return  redirect()
                ->route('admin.roles.index')
                ->with(['message' => 'Solicitud actualizada correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return  redirect()->back()
                ->with([
                    'error' => 'Error Servidor; ' . $e->getMessage(),
                ])->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitude $model)
    {
        abort_unless(Entrust::can('solicitude_show'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        $model->load('status');

        return view('solicitudes.show', compact('model'));
    }

    public function destroy(Solicitude $model)
    {
        abort_unless(Entrust::can('solicitude_delete'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        $model->estatus_id = optional(Status::where('name', 'CAN')->first())->id;
        $model->save();

        $model->delete();

        return back();
    }


    public function archivo(Solicitude $model)
    {
        return Response::make($model->adjunto, HTTPMessages::HTTP_OK, [
            'Content-Type' => $model->tipo_adjunto
        ]);
    }

    // public function storeComment(Request $request, Ticket $ticket)
    // {
    //     $request->validate([
    //         'comment_text' => 'required'
    //     ]);

    //     $comment = $ticket->comments()->create([
    //         'author_name'   => $ticket->author_name,
    //         'author_email'  => $ticket->author_email,
    //         'comment_text'  => $request->comment_text
    //     ]);

    //     $ticket->sendCommentNotification($comment);

    //     return redirect()->back()->withStatus('Your comment added successfully');
    // }
}
