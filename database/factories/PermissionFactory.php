<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use HelpDesk\Entities\Admin\Permission;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name'          => Str::snake($faker->lexify('Permission ???')),
        'display_name'  => $faker->unique()->sentence(2),
        'description'   => $faker->sentence(20)
    ];
});
