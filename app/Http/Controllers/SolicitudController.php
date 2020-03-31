<?php

namespace HelpDesk\Http\Controllers;

use Illuminate\Http\Request;
use HelpDesk\Entities\Solicitude;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use Entrust;

/**
 * Genera una solicitud por parte de los empleados
 */
class SolicitudController extends Controller
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

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()} ",])->withInput();
        }
    }

    public function storeComment(Request $request, Solicitude $model)
    {
        $request->validate([
            'comentario_texto' => 'required'
        ]);

        $comment = null;

        DB::beginTransaction();
        try {

            $comment = $model->comentarios()->create([
                'autor_nombre'     => $model->empleado->nombre,
                'autor_email'      => $model->empleado->email,
                'comentario_texto' => $request->input('comentario_texto'),
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$ex->getMessage()} "])->withInput();
        }

        $model->sendCommentNotification($comment);

        return redirect()
            ->back()
            ->with(['message' => 'Comentario agregado correctamente']);
    }

    public function archivo(Solicitude $model)
    {
        return Response::make($model->adjunto, HTTPMessages::HTTP_OK, [
            'Content-Type' => $model->tipo_adjunto
        ]);
    }
}
