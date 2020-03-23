<?php

use Illuminate\Database\Seeder;
use HelpDesk\Entities\Admin\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'        => 1,
                'nombre'    => 'Administrador',
            ],
            [
                'id'        => 2,
                'nombre'    => 'Soporte',
            ],
            [
                'id'        => 3,
                'nombre'    => 'Empleado',
            ],
        ];

        Role::insert($roles);
    }
}
