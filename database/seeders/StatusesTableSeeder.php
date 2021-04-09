<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Config;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = Config::get('helpdesk.solicitud.statuses.names', []);
        $colors = Config::get('helpdesk.solicitud.statuses.colors', []);

        foreach ($statuses as $name => $display_name) {
            Status::create([
                'name'          => $name,
                'display_name'  => $display_name,
                'color'         => $colors[$name]
            ]);
        }
    }
}
