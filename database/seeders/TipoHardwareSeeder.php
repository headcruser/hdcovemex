<?php

namespace Database\Seeders;

use HelpDesk\Entities\Inventario\TipoHardware;
use Illuminate\Database\Seeder;

class TipoHardwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # php artisan db:seed --class=TipoHardwareSeeder

        $tipoHardware = [
            [
                'descripcion' => 'Mouse'
            ],[
                'descripcion' => 'Teclado'
            ], [
                'descripcion' => 'Monitor'
            ],[
                'descripcion' => 'Gabinete'
            ],[
                'descripcion' => 'Camaras'
            ],
        ];

        foreach ($tipoHardware as $tipo) {
            TipoHardware::updateOrCreate($tipo);
        }
    }
}
