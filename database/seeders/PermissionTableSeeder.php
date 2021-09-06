<?php
namespace Database\Seeders;

use HelpDesk\Entities\Admin\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('settings.permisos',[]);

        # Permission::insert($permissions);

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name'         =>  $permission['name'] ],
                [
                    'display_name'  => $permission['display_name'],
                    'description'   => $permission['description'],
                ]
            );
        }
        # php artisan db:seed --class=PermissionTableSeeder
        #\HelpDesk\Entities\Admin\Role::findOrFail(1)->perms()->sync(\HelpDesk\Entities\Admin\Permission::all());
    }
}
