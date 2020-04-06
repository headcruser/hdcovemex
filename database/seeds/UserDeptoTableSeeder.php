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
        $deptoRH = Departamento::findOrFail(4);
        $deptoProduccion = Departamento::findOrFail(2);

        $administrador = User::findOrFail(1);
        $administrador->departamento()->associate($deptoSistemas);
        $administrador->save();

        $jefatura = User::findOrFail(2);
        $jefatura->departamento()->associate($deptoSistemas);
        $jefatura->save();

        $soporte = User::findOrFail(3);
        $soporte->departamento()->associate($deptoSistemas);
        $soporte->save();

        $programacion = User::findOrFail(4);
        $programacion->departamento()->associate($deptoSistemas);
        $programacion->save();

        $empleado1 = User::findOrFail(5);
        $empleado1->departamento()->associate($deptoRH);
        $empleado1->save();

        $empleado2 = User::findOrFail(6);
        $empleado2->departamento()->associate($deptoProduccion);
        $empleado2->save();
    }
}
