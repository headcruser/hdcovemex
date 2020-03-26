<?php

use Illuminate\Database\Seeder;
use HelpDesk\Entities\Admin\Role;
use HelpDesk\Entities\Admin\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->perms()->sync($admin_permissions->pluck('id'));

        $empleado_permissions = $admin_permissions->filter(function($permission){
            return \Str::contains($permission->name,'solicitude_') && $permission->name != 'solicitude_delete' && $permission->name != 'solicitude_edit';
        });

        Role::findOrFail(3)->perms()->sync($empleado_permissions);
    }
}
