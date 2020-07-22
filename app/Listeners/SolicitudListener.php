<?php

namespace HelpDesk\Listeners;

use Exception;
use HelpDesk\Entities\Admin\Operador;
use HelpDesk\Entities\Config\EmailError;
use HelpDesk\Events\SolicitudRegistrada;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use HelpDesk\Notifications\CreatedSolicitudeNotification;

class SolicitudListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SolicitudRegistrada  $event
     * @return void
     */
    public function handle(SolicitudRegistrada $event)
    {
        $operadores = Operador::with(['usuario'])
            ->where('notificar_solicitud',1)->get();

        foreach ($operadores as $operador) {
            if ($operador->notificar_solicitud) {
                try{
                    Notification::send($operador->usuario, new CreatedSolicitudeNotification($event->solicitud));
                }catch(Exception $e){
                    EmailError::create([
                        'user_id'       => $operador->usuario_id,
                        'subject_id'    => $event->solicitud->id,
                        'subject_type'  => get_class($event->solicitud),
                        'description'   => $e->getMessage()
                    ]);
                }
            }
        }
    }
}
