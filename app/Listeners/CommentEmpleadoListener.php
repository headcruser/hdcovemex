<?php

namespace HelpDesk\Listeners;

use HelpDesk\Entities\Config\EmailError;
use Illuminate\Queue\InteractsWithQueue;
use HelpDesk\Events\CommentEmpleadoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use HelpDesk\Notifications\CommentEmpleadoNotification;

class CommentEmpleadoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param  CommentEmpleadoEvent  $event
     * @return void
     */
    public function handle(CommentEmpleadoEvent $event)
    {
        try {

            $event->comment->load(['ticket.solicitud.empleado']);
            $operador = $event->comment->ticket->operador;

            if ($operador->isOperador()) {
                if($operador->operador->notificar_solicitud){
                    $notification = new CommentEmpleadoNotification($event->comment);
                    Notification::send($operador, $notification);
                }
            }

        }catch(\Exception $e){
            EmailError::create([
                'user_id'       => $event->comment->operador->usuario_id,
                'subject_id'    => $event->comment->id,
                'subject_type'  => get_class($event->comment),
                'description'   => $e->getMessage()
            ]);
        }

    }
}
