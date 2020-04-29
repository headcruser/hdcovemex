<?php
namespace HelpDesk\Http\Controllers\Usuario;

use Entrust;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use HelpDesk\Entities\Solicitude;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

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
    public function index(Request $request)
    {
        abort_unless(Entrust::can('solicitude_access'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        $solicitudes = Solicitude::auth()
            ->with(['status', 'empleado'])
            ->search($request->input('search'))
            ->from($request->input('from'))
            ->to($request->input('to'))
            ->byStatus($request->input('status'))
            ->orderByDesc('created_at')
            ->paginate();

        $solicitudes->appends([
            'search'    => $request->input('search'),
            'from'      => $request->input('from'),
            'to'        => $request->input('to')
        ]);

        return view('usuario.solicitudes.index', [
            'collection'    => $solicitudes,
            'statuses'      => Status::pluck('display_name', 'id'),
        ]);
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

        $model->load('status', 'ticket', 'ticket.sigoTicket');

        return view('usuario.solicitudes.show', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Entrust::can('solicitude_create'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        return view('usuario.solicitudes.create');
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
            'usuario_id'    => auth()->id(),
            'estatus_id'    => optional(Status::pendientes()->first())->id
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

            $comment = $model->ticket->sigoTicket()->create([
                'usuario_id'    => auth()->id(),
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

    public function archivo(Solicitude $model)
    {
        return Response::make($model->adjunto, HTTPMessages::HTTP_OK, [
            'Content-Type' => $model->tipo_adjunto
        ]);
    }
}
