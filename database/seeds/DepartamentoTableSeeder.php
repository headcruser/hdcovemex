<?php

use HelpDesk\Entities\Admin\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamentos = [
            [
                'id'        => 1,
                'nombre'    => 'Operaciones',
            ],
            [
                'id'        => 2,
                'nombre'    => 'Supervisores de Producción',
            ],
            [
                'id'        => 3,
                'nombre'    => 'Contabilidad-Compras',
            ],
            [
                'id'        => 4,
                'nombre'    => 'Recursos Humanos',
            ],
            [
                'id'        => 5,
                'nombre'    => 'Tecnológicas de la Información',
            ],
            [
                'id'        => 6,
                'nombre'    => 'Embarques y Logística',
            ],
            [
                'id'        => 7,
                'nombre'    => 'Administración Embolsado',
            ],
            [
                'id'        => 8,
                'nombre'    => 'Vigilancia',
            ],
            [
                'id'        => 9,
                'nombre'    => 'Vigilancia',
            ],
        ];

        Departamento::insert($departamentos);
    }
}
