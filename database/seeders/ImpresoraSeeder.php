<?php

namespace Database\Seeders;

use HelpDesk\Entities\Impresora;
use Illuminate\Database\Seeder;

class ImpresoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $impresoras = [
            [
                'nombre'        => 'iR-ADV C5235',
                'descripcion'   => 'Recursos Humanos',
                'nip'           => '206',
                'ip'            => 'http://172.16.12.206:8000/'
            ],
            [
                'nombre'        => 'iR-ADV 4245',
                'descripcion'   => 'Oficinas Planta Alta',
                'nip'           => '201',
                'ip'            => 'http://172.16.12.201:8000/'
            ],
            [
                'nombre'        => 'iR-ADV 4245',
                'descripcion'   => 'Oficinas TGAB',
                'nip'           => '204',
                'ip'            => 'http://172.16.12.204:8000/'
            ]
        ];

        foreach ($impresoras as $impresora) {
            Impresora::updateOrCreate(
                ['descripcion'         =>  $impresora['descripcion'] ],
                [
                    'nombre'    => $impresora['nombre'],
                    'nip'       => $impresora['nip'],
                    'ip'        => $impresora['ip'],
                ]
            );
        }
    }
}
