<?php

use Illuminate\Database\Seeder;
use HelpDesk\Entities\Admin\Role;
use HelpDesk\Entities\Admin\User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::findOrFail(1);
        $roleSoporte = Role::findOrFail(2);
        $roleEmpleado = Role::findOrFail(3);

        User::findOrFail(1)->attachRole($roleAdmin);
        User::findOrFail(2)->attachRole($roleSoporte);
        User::findOrFail(3)->attachRole($roleEmpleado);
    }
}
