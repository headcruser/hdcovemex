<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Admin\Operador;

$factory->define(Operador::class, function (Faker $faker) {

    $operadores = User::withRoles('soporte', 'jefatura')->get();
    $operador = $operadores->random();

    return [
        'usuario_id'            => $operador->id,
        'notificar_solicitud'   => true,
        'notificar_asignacion'  => true,
    ];
});
