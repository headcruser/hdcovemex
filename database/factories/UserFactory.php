<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Admin\{Role, User};

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'nombre'            => $faker->name,
        'email'             => preg_replace('/@example\..*/', '@covemex.com', $faker->unique()->safeEmail),
        'email_verified_at' => now(),
        'telefono'          => null,
        'usuario'           => $faker->username,
        'password'          => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
        'remember_token'    => Str::random(10),
    ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $roleEmpleado = Role::findOrFail(3);
    $user->attachRole($roleEmpleado);


    $depto = Departamento::where('nombre','!=','Tecnólogias de la Información')->get()->random();
    $user->departamento()->associate($depto);
    $user->save();
});
