<?php

namespace HelpDesk\Observers;

use HelpDesk\Entities\Admin\Operador;
use HelpDesk\Entities\Solicitude;
use HelpDesk\Notifications\CreatedSolicitudeNotification;

use Illuminate\Support\Facades\Notification;

class SolicitudeActionObserver
{
    public function created(Solicitude $model)
    {
        $operadores = Operador::with(['usuario'])
            ->where('notificar_solicitud',1)->get();

        foreach ($operadores as $operador) {
            if ($operador->notificar_solicitud) {

                # VERIFICAR ERRORES DE ENVIO DE NOTIFICACIONES
                Notification::send($operador->usuario, new CreatedSolicitudeNotification($model));
            }
        }
    }
}
