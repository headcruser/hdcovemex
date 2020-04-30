<?php

use HelpDesk\Entities\Config\Attribute;
use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_at  = now();

        $attributes = [
            [
                #'id'           => 1,
                'attribute'    => 'Contacto',
                'value'        => 'Telefonico',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 2,
                'attribute'    => 'Contacto',
                'value'        => 'Email',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 3,
                'attribute'    => 'Contacto',
                'value'        => 'Personal',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 4,
                'attribute'    => 'Estado',
                'value'        => 'Finalizado',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 5,
                'attribute'    => 'Estado',
                'value'        => 'Abierto',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 6,
                'attribute'    => 'Estado',
                'value'        => 'Cerrado',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 7,
                'attribute'    => 'Personal',
                'value'        => 'Configuracion',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 8,
                'attribute'    => 'Personal',
                'value'        => 'Instalacion',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 9,
                'attribute'    => 'Personal',
                'value'        => 'Consumibles',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 10,
                'attribute'    => 'Personal',
                'value'        => 'Control de equipo',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 11,
                'attribute'    => 'Personal',
                'value'        => 'Asesoria',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 12,
                'attribute'    => 'Personal',
                'value'        => 'Revision',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 13,
                'attribute'    => 'Personal',
                'value'        => 'Mantenimiento',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 14,
                'attribute'    => 'Personal',
                'value'        => 'Reparacion',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 15,
                'attribute'    => 'Personal',
                'value'        => 'Actualizacion',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 16,
                'attribute'    => 'Proceso',
                'value'        => 'En Proceso',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 17,
                'attribute'    => 'Proceso',
                'value'        => 'Finalizado',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 18,
                'attribute'    => 'Proceso',
                'value'        => 'En Espera',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 19,
                'attribute'    => 'Remoto',
                'value'        => 'Proveedores',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 20,
                'attribute'    => 'Remoto',
                'value'        => 'Reparacion',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 21,
                'attribute'    => 'Remoto',
                'value'        => 'Consumibles',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 22,
                'attribute'    => 'Remoto',
                'value'        => 'Desarrollo',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 23,
                'attribute'    => 'Remoto',
                'value'        => 'Revision',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 24,
                'attribute'    => 'Remoto',
                'value'        => 'Asesoria',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 25,
                'attribute'    => 'Remoto',
                'value'        => 'Instalación',
                'created_at'   => $created_at
            ],

            [
                #'id'           => 26,
                'attribute'    => 'Remoto',
                'value'        => 'Configuración',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 27,
                'attribute'    => 'Remoto',
                'value'        => 'Actualización',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 28,
                'attribute'    => 'Tipo',
                'value'        => 'Personal',
                'created_at'   => $created_at
            ],
            [
                #'id'           => 29,
                'attribute'    => 'Tipo',
                'value'        => 'Remoto',
                'created_at'   => $created_at
            ],
        ];

        Attribute::insert($attributes);
    }
}
