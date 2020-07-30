<?php

namespace HelpDesk\Notifications;

use Config;
use Illuminate\Bus\Queueable;
use HelpDesk\Entities\SigoTicket;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentEmpleadoNotification extends Notification
{
    use Queueable;

    protected $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( SigoTicket $comment)
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = str_replace(
            ['%usuario_id%','%usuario_nombre%','%ticket_id%'],
            [$this->comment->operador->id, $this->comment->operador->nombre,$this->comment->ticket->id],
            Config::get('helpdesk.mail.alert_ticket_comment_subject')
        );

        $mailMessage =  (new MailMessage)
        ->subject( $subject )
        ->greeting('Solicitud de soporte: #'. $this->comment->ticket->solicitud->id)
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
            'accion'        => "El empledo ha comentado la solicitud" ,
            'fecha'         => now()->format('d/m/y'),
            'hora'          => now()->format('h:i'),
            'creado_por'    => $this->comment->ticket->solicitud->empleado->nombre,
            'route'         => route('operador.tickets.show',$this->comment->ticket)
        ];
    }
}
