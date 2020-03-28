<?php

namespace HelpDesk\Notifications;

use Illuminate\Bus\Queueable;
use HelpDesk\Entities\Solicitude;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CreatedSolicitudeNotification extends Notification
{
    use Queueable;

    protected $solicitude;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Solicitude $solicitude)
    {
        $this->solicitude = $solicitude;
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
        ->subject('Solicitud de Gastos Enviada');
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
            'titulo'        => $this->solicitude->titulo,
            'detalle'       => $this->solicitude->incidente,
            'accion'        => 'Solicitud Creada',
            'fecha'         => $this->solicitude->fecha->format('d/m/Y'),
            'hora'          => $this->solicitude->fecha->format('h:i'),
            'creado_por'    => $this->solicitude->empleado->nombre,
            'route'         => route('solicitudes.show',$this->solicitude)
        ];
    }
}
