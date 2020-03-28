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
        $users = User::withRole('admin')->get();
        Notification::send($users, new CreatedSolicitudeNotification($model));
    }
}
