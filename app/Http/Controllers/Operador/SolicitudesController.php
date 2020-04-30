<?php

namespace HelpDesk\Http\Controllers\Operador;

use Entrust;

use HelpDesk\Entities\Solicitude;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

/**
 * Administra las solicitudes por medio del operador
 */
class SolicitudesController extends Controller
{
    public function index(Request $request)
    {
        $verifyAccess = Entrust::hasRole(['soporte']) && Entrust::can('solicitude_access');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        // $validator = Validator::make($request->all(), [
        //     'search'    => 'filled',
        //     'status'    =>  Rule::exists('statuses', 'id')->whereNull('deleted_at'),
        //     'from'      => 'date_format:d/m/Y',
        //     'to'        => 'date_format:d/m/Y',
        // ]);

        $defaultStatus = optional(Status::pendientes()->first())->id;

        if ($request->has('status')) {
            $status = $request->input('status');
        } else {
            $status = $defaultStatus;
        }

        $solicitudes = Solicitude::with(['status', 'empleado', 'empleado.departamento'])
            ->search($request->input('search'))
            ->from($request->input('from'))
            ->to($request->input('to'))
            ->byStatus($status)
            ->orderByDesc('created_at')
            ->paginate();

        $solicitudes->appends([
            'search'    => $request->input('search'),
            'from'      => $request->input('from'),
            'to'        => $request->input('to'),
            'status'    => $defaultStatus,
        ]);

        return view('operador.solicitudes.index', [
            'collection'    => $solicitudes,
            'statuses'      => Status::pluck('display_name', 'id'),
            'status'        => $status
        ]);
    }

    public function edit(Solicitude $model)
    {
        $verifyAccess = Entrust::hasRole(['soporte']) && Entrust::can('solicitude_edit');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->load('status');

        return view('operador.solicitudes.edit', [
            'model'     => $model,
            'statuses'  => Status::all()->pluck('display_name', 'id')->toArray()
        ]);
    }


    public function update(Request $request, Solicitude $model)
    {
        DB::beginTransaction();
        $user = Auth::user();

        try {
            if ($request->has('abrir-ticket')) {

                $ticket = $model->ticket()->create([
                    'fecha'         => now(),
                    'titulo'        => "Atentiendo Solicitud {$model->id}",
                    'usuario_id'    => $model->usuario_id,
                    'incidente'     => $model->incidente,
                    'estado'        => Config::get('helpdesk.tickets.estado.alias.ABT'),
                    'asignado_a'    => $user->id,
                    'privado'       => 'N',
                    'operador_id'   => $user->id,
                    'contacto'      => 'email',
                    'prioridad'     => 3,
                    'proceso'       => 'En Proceso',
                    'tipo'          => 'Personal',
                    'sub_tipo'      => '',
                ]);

                $model->ticket_id = $ticket->id;
                $model->estatus_id = optional(Status::proceso()->first())->id;

                $model->save();
                DB::commit();

                return redirect()
                    ->route('operador.tickets.show', $ticket)
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
        $verifyAccess = Entrust::hasRole(['soporte']) && Entrust::can('solicitude_show');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('operador.solicitudes.show', compact('model'));
    }

    public function destroy(Solicitude $model)
    {
        $verifyAccess = Entrust::hasRole(['soporte']) && Entrust::can('solicitude_delete');

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->estatus_id = optional(Status::canceladas()->first())->id;
        $model->save();

        $model->delete();

        return back();
    }

    public function archivo(Solicitude $model)
    {
        $model->load('media');

        abort_if(empty($model->media), HTTPMessages::HTTP_FORBIDDEN, __('No se ha asignado ningun archivo'));

        $path = storage_path('tmp' . DIRECTORY_SEPARATOR . 'uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }
        } catch (\Exception $e) {
        }

        $data = explode(',', $model->media->file);
        $content = base64_decode($data[1]);

        $nameFile = $path . DIRECTORY_SEPARATOR . $model->media->name;

        file_put_contents($nameFile, $content);

        return response()->download($nameFile)->deleteFileAfterSend(true);
    }
}
