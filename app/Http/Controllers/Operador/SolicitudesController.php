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
        $userAuth = Auth::user();

        $verifyAccess =  (Entrust::hasRole(['admin']) || $userAuth->isOperador()) && $userAuth->can('solicitude_access');

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
        $userAuth = Auth::user();

        $verifyAccess = (Entrust::hasRole(['admin']) || $userAuth->isOperador()) && $userAuth->can('solicitude_delete');

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

        $pathFile = $model->media->buildMediaFilePath();

        return response()->download($pathFile)->deleteFileAfterSend(true);
    }
}
