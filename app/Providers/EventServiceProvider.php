<?php

namespace HelpDesk\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        # REGISTRO DE SOLICITUD
        'HelpDesk\Events\SolicitudRegistrada' => [
            'HelpDesk\Listeners\SolicitudListener'
        ],

        # COMENTARIO DE OPERADORES
        'HelpDesk\Events\CommentOperatorEvent' => [
            'HelpDesk\Listeners\CommentOperatorListener'
        ],

        # COMENTARIO DE EMPLEADOS
        'HelpDesk\Events\CommentEmpleadoEvent' => [
            'HelpDesk\Listeners\CommentEmpleadoListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
