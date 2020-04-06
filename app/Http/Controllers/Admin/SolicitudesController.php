<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;

use HelpDesk\Entities\Solicitude;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class SolicitudesController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitude::with(['status', 'empleado', 'empleado.departamento'])
            ->select(sprintf('%s.*', (new Solicitude())->table))->paginate();

        return view('admin.solicitudes.index', [
            'collection' => $solicitudes
        ]);
    }

    public function edit(Solicitude $model)
    {
        abort_unless(Entrust::can('solicitude_edit'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        $model->load('status');

        return view('admin.solicitudes.edit', [
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

    public function show(Solicitude $model)
    {
        abort_unless(Entrust::can('ticket_show'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        #$model->load('comentarios');

        return view('admin.solicitudes.show', compact('model'));
    }

    // public function storeComment(Request $request, Solicitude $model)
    // {
    //     $request->validate([
    //         'comentario_texto' => 'required'
    //     ]);

    //     $user = auth()->user();
    //     $comentario = null;

    //     DB::beginTransaction();
    //     try {
    //         $comentario = $model->comentarios()->create([
    //             'autor_nombre'     => $user->nombre,
    //             'autor_email'      => $user->email,
    //             'usuario_id'       => $user->id,
    //             'comentario_texto' => $request->input('comentario_texto'),
    //         ]);

    //         DB::commit();
    //     } catch (\Exception $ex) {
    //         DB::rollback();

    //         return redirect()
    //             ->back()
    //             ->with(['error' => "Error Servidor: {$ex->getMessage()} "])->withInput();
    //     }

    //     $model->sendCommentNotification($comentario);

    //     return redirect()
    //         ->back()
    //         ->with(['message' => 'Comentario agregado correctamente']);
    // }

    public function destroy(Solicitude $model)
    {
        abort_unless(Entrust::can('solicitude_delete'), HTTPMessages::HTTP_FORBIDDEN, '403 Forbidden');

        $model->estatus_id = optional(Status::where('name', 'CAN')->first())->id;
        $model->save();

        $model->delete();

        return back();
    }

}
