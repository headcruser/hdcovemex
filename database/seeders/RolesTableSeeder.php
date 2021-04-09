<?php
namespace Database\Seeders;

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
                #'id'            => 1,
                'name'          => 'admin',
                'display_name'  => 'Administrador',
                'description'   => 'Usuario que administra y edita a otros usuarios'
            ],
            [
                #'id'            => 2,
                'name'          => 'soporte',
                'display_name'  => 'Soporte TI',
                'description'   => 'Usuario encargado de dar segumiento a los tikets.'
            ],
            [
                #'id'            => 3,
                'name'          => 'empleado',
                'display_name'  => 'Empleado',
                'description'   => 'Usuario que genera solicitudes.'
            ],
            [
                #'id'            => 4,
                'name'          => 'jefatura',
                'display_name'  => 'jefatura',
                'description'   => 'Jefe del departamento'
            ],
        ];

        Role::insert($roles);
    }
}
