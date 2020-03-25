<?php

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
        $permissions = [
            [
                'id'            => 1,
                'name'          => 'user_management_access',
                'display_name'  => 'Acceso administracion',
                'description'   => 'Permite el acceso a la seccion de administracion'
            ],
            [
                'id'            => 2,
                'name'          => 'permission_create',
                'display_name'  => 'Crear Permiso',
                'description'   => 'Permite Crear un permiso'
            ],
            [
                'id'            => 3,
                'name'          => 'permission_edit',
                'display_name'  => 'Editar Permiso',
                'description'   => 'Permite Editar un permiso'
            ],
            [
                'id'            => 4,
                'name'          => 'permission_show',
                'display_name'  => 'Ver permiso',
                'description'   => 'Permite ver el detalle de un permiso'
            ],
            [
                'id'            => 5,
                'name'          => 'permission_delete',
                'display_name'  => 'Eliminar permiso',
                'description'   => 'Permite Eliminar un permiso'
            ],
            [
                'id'            => 6,
                'name'          => 'permission_access',
                'display_name'  => 'Acceso a permisos',
                'description'   => 'Permite el acceso a la vista de permisos'
            ],

            [
                'id'            => 7,
                'name'          => 'role_create',
                'display_name'  => 'Crear rol',
                'description'   => 'Permite Crear un rol'
            ],
            [
                'id'            => 8,
                'name'          => 'role_edit',
                'display_name'  => 'Editar rol',
                'description'   => 'Permite Editar un rol'
            ],
            [
                'id'            => 9,
                'name'          => 'role_show',
                'display_name'  => 'Ver rol',
                'description'   => 'Permite ver el detalle de un rol'
            ],
            [
                'id'            => 10,
                'name'          => 'role_delete',
                'display_name'  => 'Eliminar rol',
                'description'   => 'Permite Eliminar un rol'
            ],
            [
                'id'            => 11,
                'name'          => 'role_access',
                'display_name'  => 'Acceso a roles',
                'description'   => 'Permite el acceso a la vista de roles'
            ],

            [
                'id'            => 12,
                'name'          => 'user_create',
                'display_name'  => 'Crear Usuario',
                'description'   => 'Permite Crear un usuario'
            ],
            [
                'id'            => 13,
                'name'          => 'user_edit',
                'display_name'  => 'Editar Usuario',
                'description'   => 'Permite Editar un usuario'
            ],
            [
                'id'            => 14,
                'name'          => 'user_show',
                'display_name'  => 'Ver Usuario',
                'description'   => 'Permite ver el detalle de un usuario'
            ],
            [
                'id'            => 15,
                'name'          => 'user_delete',
                'display_name'  => 'Eliminar Usuario',
                'description'   => 'Permite Eliminar un usuario'
            ],
            [
                'id'            => 16,
                'name'          => 'user_access',
                'display_name'  => 'Acceso a usuarios',
                'description'   => 'Permite el acceso a la vista de usuarios'
            ],
        ];

        Permission::insert($permissions);
    }
}
