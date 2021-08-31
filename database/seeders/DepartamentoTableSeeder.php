<?php
namespace Database\Seeders;

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
                #'id'        => 1,
                'nombre'    => 'Operaciones',
            ],
            [
                #'id'        => 2,
                'nombre'    => 'Supervisores de Producción',
            ],
            [
                #'id'        => 3,
                'nombre'    => 'Contabilidad',
            ],
            [
                #'id'        => 4,
                'nombre'    => 'Recursos Humanos',
            ],
            [
                #'id'        => 5,
                'nombre'    => 'Tecnologías de la Información',
            ],
            [
                #'id'        => 6,
                'nombre'    => 'Administración Embolsado',
            ],
            [
                #'id'        => 7,
                'nombre'    => 'Logística',
            ],
            [
                #'id'        => 8,
                'nombre'    => 'Vigilancia',
            ],
            [
                #'id'        => 9,
                'nombre'    => 'TGAB',
            ],
            [
                #'id'        => 10,
                'nombre'    => 'Almacén',
            ],
            [
                #'id'        => 11,
                'nombre'    => 'Materia Prima',
            ],
            [
                #'id'        => 12,
                'nombre'    => 'Ventas',
            ],
            [
                #'id'        => 13,
                'nombre'    => 'Compras',
            ],
            [
                #'id'        => 14,
                'nombre'    => 'Monitoreo',
            ],
            [
                #'id'        => 15,
                'nombre'    => 'Mantenimiento',
            ],
            [
                #'id'        => 16,
                'nombre'    => 'Almacén',
            ],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::updateOrCreate(
                ['nombre'         =>  $departamento['nombre'] ],
                []
            );
        }

        // Departamento::insert($departamentos);
    }
}
