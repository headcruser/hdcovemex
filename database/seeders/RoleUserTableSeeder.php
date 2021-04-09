<?php
namespace Database\Seeders;

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
        $roleTI = Role::findOrFail(4);

        User::findOrFail(1)->attachRole($roleAdmin);
        User::findOrFail(2)->attachRole($roleTI);
        User::findOrFail(3)->attachRole($roleSoporte);
        User::findOrFail(4)->attachRole($roleSoporte);
        User::findOrFail(5)->attachRole($roleEmpleado);
        User::findOrFail(6)->attachRole($roleEmpleado);
    }
}
