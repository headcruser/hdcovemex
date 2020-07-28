<?php
namespace HelpDesk\Http\Controllers\Usuario;

use Entrust;

use HelpDesk\Entities\Media;
use HelpDesk\Entities\Solicitude;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Events\SolicitudRegistrada;
use HelpDesk\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $verifyAccess = Entrust::hasRole(['empleado']) && Entrust::can('solicitude_access');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

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
        $verifyAccess = Entrust::hasRole(['empleado']) && Entrust::can('solicitude_show');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->load(['status', 'ticket', 'ticket.sigoTicket' => function($query){
            $query->where('comentario','!=','');
        }]);

        return view('usuario.solicitudes.show', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $verifyAccess = Entrust::hasRole(['empleado']) && Entrust::can('solicitude_create');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

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

        DB::beginTransaction();

        $solicitud = null;

        try {
            $solicitud = Solicitude::create($request->all());

            if (!empty($file)) {

                $media = Media::createMediaArray($file);

                $solicitud->media()->create($media);
                $solicitud->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()} ",])->withInput();
        }

        event(new SolicitudRegistrada($solicitud));

        return redirect()
            ->route('solicitudes.show', $solicitud)
            ->withStatus("Tu solicitud ha sido enviada. Te atenderemos a la brevedad posible");
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
        $model->load('media');

        abort_if(empty($model->media), HTTPMessages::HTTP_FORBIDDEN, __('No se ha asignado ningun archivo'));

        $pathFile = $model->media->buildMediaFilePath();

        return response()->download($pathFile)->deleteFileAfterSend(true);
    }
}
