<?php

namespace HelpDesk\Observers;

use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Solicitude;
use HelpDesk\Notifications\CreatedSolicitudeNotification;
use Illuminate\Support\Facades\Notification;

class SolicitudeActionObserver
{
    public function created(Solicitude $model)
    {
        # ALGORIMO PARA DETERMINAR A QUE USUARIO SE ENVIA LA NOTIFICACION
        $users = User::withRoles('soporte','jefatura')->get();

        # VERIFICAR ERRORES DE ENVIO DE NOTIFICACIONES
        Notification::send($users, new CreatedSolicitudeNotification($model));
    }
}
