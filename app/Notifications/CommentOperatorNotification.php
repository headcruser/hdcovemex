<?php

namespace HelpDesk\Notifications;

use HelpDesk\Entities\SigoTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Config;

class CommentOperatorNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SigoTicket $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage =  (new MailMessage)
        ->subject( str_replace('%solicitud_id%', $this->comment->ticket->solicitud->id ,Config::get('helpdesk.mail.alert_comment_subject')) )
        ->greeting('Nuevo Comentario en la solicitud: #'. $this->comment->ticket->solicitud->id)
        ->line("El usuario {$this->comment->ticket->operador->nombre} agrego un nuevo Comentario")
        ->line("Detalle: {$this->comment->comentario}")
        ->salutation(Config::get('helpdesk.global.name'))
        ->from(Config::get('helpdesk.global.from_user_request'), Config::get('helpdesk.global.name'));

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'titulo'        => "Ha realizado un comentario en la solicitud #{$this->comment->ticket->solicitud->id}",
            'detalle'       => $this->comment->comentario,
            'accion'        => 'Operador comentando solicitud',
            'fecha'         => now()->format('d/m/y'),
            'hora'          => now()->format('h:i'),
            'creado_por'    => $this->comment->operador->nombre,
            'route'         => route('solicitudes.show',$this->comment->ticket->solicitud)
        ];
    }
}
