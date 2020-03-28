<?php

use Illuminate\Database\Seeder;
use HelpDesk\Entities\Config\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #$faker = Faker\Factory::create();

        $statuses = [
            'PEN'   => 'Pendiente',
            'PAS'   => 'En proceso',
            'END'   => 'Finalizada',
            'CAN'   => 'Cancelada',
        ];

        $colors = [
            'PEN' => '#ffc107',
            'PAS' => '#6c757d',
            'END' => '#28a745',
            'CAN' => '#dc3545',
        ];

        foreach ($statuses as $name => $display_name) {
            Status::create([
                'name'          => $name,
                'display_name'  => $display_name,
                'color'         => $colors[$name]
            ]);
        }
    }
}
