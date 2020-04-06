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
        $permissions = Permission::all();

        $empleado_permissions = $permissions->filter(function($permission){
            return \Str::contains($permission->name,'solicitude_')
                && $permission->name != 'solicitude_delete'
                && $permission->name != 'solicitude_edit';
        });

        $soporte_permissions = $permissions->filter(function($permission){
            return (\Str::contains($permission->name,'ticket_') ||
                \Str::contains($permission->name,'solicitude_') ||
                \Str::contains($permission->name,'user_') ||
                \Str::contains($permission->name,'departament_')) &&
                $permission->name != 'user_config_access' &&
                $permission->name != 'user_manager_access';
        });

        Role::findOrFail(1)->perms()->sync($permissions);
        Role::findOrFail(2)->perms()->sync($soporte_permissions);
        Role::findOrFail(3)->perms()->sync($empleado_permissions);
        Role::findOrFail(4)->perms()->sync($permissions);
    }
}
