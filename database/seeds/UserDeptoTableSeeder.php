<?php

use Illuminate\Database\Seeder;
use HelpDesk\Entities\Admin\{User, Departamento};

class UserDeptoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deptoSistemas = Departamento::findOrFail(5);

        $administrador = User::findOrFail(1);
        $administrador->departamento()->associate($deptoSistemas);
        $administrador->save();

        $soporte = User::findOrFail(2);
        $soporte->departamento()->associate($deptoSistemas);
        $soporte->save();

    }
}
