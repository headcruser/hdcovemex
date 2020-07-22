<?php

namespace HelpDesk\Events;

use HelpDesk\Entities\Solicitude;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SolicitudRegistrada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $solicitud ;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Solicitude $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('solicitud-registrada');
    }
}
