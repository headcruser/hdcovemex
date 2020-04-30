<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\SigoTicket;
use Illuminate\Support\Facades\Config;

$factory->define(Ticket::class, function (Faker $faker) {

    $user = optional(User::withRole('soporte')->get()->random())->id;

    return [
        'fecha'         => now(),
        'privado'       => $faker->randomElement(Config::get('helpdesk.global.visibilidad.values', [])),
        'operador_id'   => $user,
        'usuario_id'    => $user,
        'contacto'      => $faker->randomElement(Config::get('helpdesk.tickets.contacto.values', [])),
        'prioridad'     => $faker->randomElement(array_keys(Config::get('helpdesk.tickets.prioridad.values', []))),
        'titulo'        => $faker->sentence(2),
        'incidente'     => $faker->text(),
        'proceso'       => $faker->randomElement(Config::get('helpdesk.tickets.proceso.values')),
        'tipo'          => $faker->randomElement(array_keys(Config::get('helpdesk.tickets.tipo.values'))),
        'sub_tipo'      => '',
        'estado'        => $faker->randomElement(['Abierto', 'Cancelado', 'Finalizado']),
        'asignado_a'    => optional(User::withRole('soporte')->get()->random())->id
    ];
});


$factory->afterCreatingState(Ticket::class, 'comentario', function ($ticket, $faker) {

    $comentario = new SigoTicket([
        'operador_id'   => $ticket->usuario_id,
        'usuario_id'    => null,
        'fecha'         => now(),
        'comentario'    => $faker->text(),
        'visible'       => 'S',
    ]);

    $ticket->sigoTicket()->save($comentario);
});
