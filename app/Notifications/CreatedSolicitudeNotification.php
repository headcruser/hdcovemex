<?php

namespace HelpDesk\Notifications;

use HelpDesk\Entities\Solicitude;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
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
        ->subject( str_replace('%1%', $this->solicitude->id ,Config::get('helpdesk.mail.request_subject')) )
        ->markdown('vendor.mail.html.operadores.solicitud',[
            'usuario'   => $notifiable,
            'solicitud' => $this->solicitude
        ])->from(Config::get('helpdesk.global.from_user_request'), Config::get('helpdesk.global.name'));

        if ($this->solicitude->media->exists) {
            $data = $this->solicitude->media->getBase64Decode();
            $mailMessage->attachData($data['content'],$data['name']);
        }

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
            'titulo'        => $this->solicitude->titulo,
            'detalle'       => $this->solicitude->incidente,
            'accion'        => 'Solicitud Creada',
            'fecha'         => $this->solicitude->fecha->format('d/m/Y'),
            'hora'          => $this->solicitude->fecha->format('h:i'),
            'creado_por'    => $this->solicitude->empleado->nombre,
            'route'         => route('operador.gestion-solicitudes.show',$this->solicitude), # Operator visualization
        ];
    }
}
