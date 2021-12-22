<?php
namespace HelpDesk\Http\Controllers\Usuario;

use Carbon\Carbon;
use Entrust;

use HelpDesk\Entities\Media;
use Illuminate\Http\Request;
use HelpDesk\Entities\Solicitude;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Status;

use HelpDesk\Events\SolicitudRegistrada;
use HelpDesk\Events\CommentEmpleadoEvent;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;
use Yajra\DataTables\Facades\DataTables;

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

        // $solicitudes = Solicitude::auth()
        //     ->with(['status', 'empleado'])
        //     ->search($request->input('search'))
        //     ->from($request->input('from'))
        //     ->to($request->input('to'))
        //     ->byStatus($request->input('status'))
        //     ->orderByDesc('created_at')
        //     ->paginate();

        // $solicitudes->appends([
        //     'search'    => $request->input('search'),
        //     'from'      => $request->input('from'),
        //     'to'        => $request->input('to')
        // ]);

        return view('usuario.solicitudes.index', [
            'statuses'      => Status::pluck('display_name', 'id')->prepend('Todos',''),
        ]);
    }

    public function datatables(Request $request)
    {
        $query = Solicitude::query()->select('solicitudes.*')
            ->auth()
            ->when($request->input('status'),function($q,$status){
                $q->where('estatus_id',$status);
            })
            ->when($request->filled(['from','to']),function($q) use($request){
                $formatFrom = Carbon::parse($request->input('from'));
                $formatTo  = Carbon::parse($request->input('to'));

                $q->whereBetween('fecha',[$formatFrom,$formatTo]);
            })->with(['status']);

        return DataTables::eloquent($query)
            ->editColumn('fecha',function($model){
                return $model->fecha->format('d/m/Y H:i a');
            })
            ->addColumn('label_status',function($model){
                return "<span class='badge badge-primary text-sm'style='background-color:{$model->status->color}'>{$model->status->display_name}</span>";
            })
            ->addColumn('buttons', 'usuario.solicitudes.datatables._buttons')
            ->rawColumns(['buttons','label_status'])
            ->make(true);

    }

    /**
     * Display the specified resource.
     *
     * @param  Solicitude  $model
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

    /**
     * create new Comment for the user (Employe)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Solicitude  $model
     * @return \Illuminate\Http\Response
     */
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

        event(new CommentEmpleadoEvent($comment));

        return redirect()
            ->back()
            ->with(['message' => 'Comentario agregado correctamente']);
    }

    /**
     * Upload file for solicitude
     *
     * @param Solicitude $model
     * @return \Illuminate\Http\Response
     */
    public function archivo(Solicitude $model)
    {
        $model->load('media');

        abort_if(empty($model->media), HTTPMessages::HTTP_FORBIDDEN, __('No se ha asignado ningun archivo'));

        $url = $model->media->buildMediaFilePath();

        return response()->download($url)->deleteFileAfterSend(true);
    }
}
