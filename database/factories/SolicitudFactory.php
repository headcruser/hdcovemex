<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Solicitude;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Config;

$factory->define(Solicitude::class, function (Faker $faker) {
    return [
        'fecha'         => now(),
        'usuario_id'    => optional(User::withRole('empleado')->get()->random())->id,
        'estatus_id'    => optional(Status::pendientes()->first())->id,
        'titulo'        => $faker->sentence(2),
        'incidente'     => $faker->text(),
    ];
});

$factory->afterCreatingState(Solicitude::class, 'ticket', function ($solicitud, $faker) {

    $ticket = factory(Ticket::class)->state('comentario')->create([
        'titulo'        => 'Atentiendo Solicitud ' . $solicitud->id,
        'usuario_id'    => $solicitud->usuario_id,
        'incidente'     => $solicitud->incidente,
        'estado'        => Config::get('helpdesk.tickets.estado.alias.ABT'),
    ]);

    $solicitud->ticket()->associate($ticket);
    $solicitud->estatus_id = optional(Status::proceso()->first())->id;
    $solicitud->save();
});

