<?php

namespace Database\Seeders;

use HelpDesk\Entities\Inventario\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # php artisan db:seed --class=SucursalSeeder

        $data = [
            [
                'descripcion' => 'Covemex'
            ],[
                'descripcion' => 'TGAB'
            ],
        ];

        foreach ($data as $item) {
            Sucursal::updateOrCreate($item);
        }
    }
}
