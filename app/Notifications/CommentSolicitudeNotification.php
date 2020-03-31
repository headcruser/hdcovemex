<?php

namespace HelpDesk\Notifications;

use HelpDesk\Entities\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentSolicitudeNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'titulo'        => 'Ha realizado un comentario',
            'detalle'       => $this->comment->comentario_texto,
            'accion'        => 'Solicitud Comentada',
            'fecha'         => $this->comment->created_at->format('d/m/y'),
            'hora'          => $this->comment->created_at->format('h:i'),
            'creado_por'    => $this->comment->autor_nombre,
            'route'         => route('solicitudes.show',$this->comment->solicitud->id)
        ];
    }
}
