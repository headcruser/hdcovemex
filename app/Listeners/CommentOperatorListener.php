<?php

namespace HelpDesk\Listeners;

use HelpDesk\Entities\Config\EmailError;
use HelpDesk\Events\CommentOperatorEvent;
use Illuminate\Support\Facades\Notification;
use HelpDesk\Notifications\CommentOperatorNotification;


class CommentOperatorListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Handle the event.
     *
     * @param  CommentOperatorEvent  $event
     * @return void
     */
    public function handle(CommentOperatorEvent $event)
    {
        try {
            $event->comment->load(['ticket.solicitud.empleado']);

            $notification = new CommentOperatorNotification($event->comment);
            Notification::send($event->comment->ticket->solicitud->empleado, $notification);

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
