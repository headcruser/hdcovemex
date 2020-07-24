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
                ##'id'            => 1,
                'name'          => 'user_management_access',
                'display_name'  => 'Acceso administracion',
                'description'   => 'Permite el acceso a la seccion de administracion'
            ],
            [
                #'id'            => 2,
                'name'          => 'permission_create',
                'display_name'  => 'Crear Permiso',
                'description'   => 'Permite Crear un permiso'
            ],
            [
                #'id'            => 3,
                'name'          => 'permission_edit',
                'display_name'  => 'Editar Permiso',
                'description'   => 'Permite Editar un permiso'
            ],
            [
                #'id'            => 4,
                'name'          => 'permission_show',
                'display_name'  => 'Ver permiso',
                'description'   => 'Permite ver el detalle de un permiso'
            ],
            [
                #'id'            => 5,
                'name'          => 'permission_delete',
                'display_name'  => 'Eliminar permiso',
                'description'   => 'Permite Eliminar un permiso'
            ],
            [
                #'id'            => 6,
                'name'          => 'permission_access',
                'display_name'  => 'Acceso a permisos',
                'description'   => 'Permite el acceso a la vista de permisos'
            ],

            [
                #'id'            => 7,
                'name'          => 'role_create',
                'display_name'  => 'Crear rol',
                'description'   => 'Permite Crear un rol'
            ],
            [
                #'id'            => 8,
                'name'          => 'role_edit',
                'display_name'  => 'Editar rol',
                'description'   => 'Permite Editar un rol'
            ],
            [
                #'id'            => 9,
                'name'          => 'role_show',
                'display_name'  => 'Ver rol',
                'description'   => 'Permite ver el detalle de un rol'
            ],
            [
                #'id'            => 10,
                'name'          => 'role_delete',
                'display_name'  => 'Eliminar rol',
                'description'   => 'Permite Eliminar un rol'
            ],
            [
                #'id'            => 11,
                'name'          => 'role_access',
                'display_name'  => 'Acceso a roles',
                'description'   => 'Permite el acceso a la vista de roles'
            ],

            [
                #'id'            => 12,
                'name'          => 'user_create',
                'display_name'  => 'Crear Usuario',
                'description'   => 'Permite Crear un usuario'
            ],
            [
                #'id'            => 13,
                'name'          => 'user_edit',
                'display_name'  => 'Editar Usuario',
                'description'   => 'Permite Editar un usuario'
            ],
            [
                #'id'            => 14,
                'name'          => 'user_show',
                'display_name'  => 'Ver Usuario',
                'description'   => 'Permite ver el detalle de un usuario'
            ],
            [
                #'id'            => 15,
                'name'          => 'user_delete',
                'display_name'  => 'Eliminar Usuario',
                'description'   => 'Permite Eliminar un usuario'
            ],
            [
                #'id'            => 16,
                'name'          => 'user_access',
                'display_name'  => 'Acceso a usuarios',
                'description'   => 'Permite el acceso a la vista de usuarios'
            ],
            [
                #'id'            => 17,
                'name'          => 'user_config_access',
                'display_name'  => 'Acceso administracion',
                'description'   => 'Permite el acceso a la seccion de configuración'
            ],

            [
                #'id'            => 18,
                'name'          => 'attribute_create',
                'display_name'  => 'Crear Atributo',
                'description'   => 'Permite Crear un atributo'
            ],
            [
                #'id'            => 19,
                'name'          => 'attribute_edit',
                'display_name'  => 'Editar Atributo',
                'description'   => 'Permite Editar un atributo'
            ],
            [
                #'id'            => 20,
                'name'          => 'attribute_show',
                'display_name'  => 'Ver Atributo',
                'description'   => 'Permite ver el detalle de un atributo'
            ],
            [
                #'id'            => 21,
                'name'          => 'attribute_delete',
                'display_name'  => 'Eliminar atributo',
                'description'   => 'Permite Eliminar un atributo'
            ],
            [
                #'id'            => 22,
                'name'          => 'attribute_access',
                'display_name'  => 'Acceso atributos',
                'description'   => 'Permite el acceso a la vista de atributos'
            ],
            [
                #'id'            => 23,
                'name'          => 'user_manager_access',
                'display_name'  => 'Acceso Gestión',
                'description'   => 'Permite el acceso a la gestion de recursos'
            ],

            [
                #'id'            => 24,
                'name'          => 'solicitude_create',
                'display_name'  => 'Crear Solicitud',
                'description'   => 'Permite Crear una solicitud'
            ],
            [
                #'id'            => 25,
                'name'          => 'solicitude_edit',
                'display_name'  => 'Editar Solicitud',
                'description'   => 'Permite Editar una solicitud'
            ],
            [
                #'id'            => 26,
                'name'          => 'solicitude_show',
                'display_name'  => 'Ver Solicitud',
                'description'   => 'Permite ver el detalle de la solicitud'
            ],
            [
                #'id'            => 27,
                'name'          => 'solicitude_delete',
                'display_name'  => 'Eliminar Solicitud',
                'description'   => 'Permite Eliminar un usuario'
            ],
            [
                #'id'            => 28,
                'name'          => 'solicitude_access',
                'display_name'  => 'Acceso a solicitudes',
                'description'   => 'Permite el acceso a la vista de solicitudes'
            ],

            [
                #'id'            => 29,
                'name'          => 'status_create',
                'display_name'  => 'Crear estatus',
                'description'   => 'Permite Crear estatus'
            ],
            [
                #'id'            => 30,
                'name'          => 'status_edit',
                'display_name'  => 'Editar estatus',
                'description'   => 'Permite Editar estatus'
            ],
            [
                #'id'            => 31,
                'name'          => 'status_show',
                'display_name'  => 'Ver estatus',
                'description'   => 'Permite ver el detalle del estatus'
            ],
            [
                #'id'            => 32,
                'name'          => 'status_delete',
                'display_name'  => 'Eliminar estatus',
                'description'   => 'Permite Eliminar un usuario'
            ],
            [
                #'id'            => 33,
                'name'          => 'status_access',
                'display_name'  => 'Acceso a estatus',
                'description'   => 'Permite el acceso a la vista de estatuses'
            ],
            [
                #'id'            => 34,
                'name'          => 'departament_create',
                'display_name'  => 'Crear departamentos',
                'description'   => 'Permite crear departamentos'
            ],
            [
                #'id'            => 35,
                'name'          => 'departament_edit',
                'display_name'  => 'Editar departamentos',
                'description'   => 'Permite editar departamentos'
            ],
            [
                #'id'            => 36,
                'name'          => 'departament_show',
                'display_name'  => 'Ver departamentos',
                'description'   => 'Permite ver el detalle del departamentos'
            ],
            [
                #'id'            => 37,
                'name'          => 'departament_delete',
                'display_name'  => 'Eliminar departamentos',
                'description'   => 'Permite eliminar un departamento'
            ],
            [
                #'id'            => 38,
                'name'          => 'departament_access',
                'display_name'  => 'Acceso a departamentos',
                'description'   => 'Permite el acceso a la vista de departamentos'
            ],
            [
                #'id'            => 39,
                'name'          => 'ticket_create',
                'display_name'  => 'Crear tickets',
                'description'   => 'Permite crear tickets'
            ],
            [
                #'id'            => 40,
                'name'          => 'ticket_edit',
                'display_name'  => 'Editar tickets',
                'description'   => 'Permite editar tickets'
            ],
            [
                #'id'            => 41,
                'name'          => 'ticket_show',
                'display_name'  => 'Ver tickets',
                'description'   => 'Permite ver el detalle del tickets'
            ],
            [
                #'id'            => 42,
                'name'          => 'ticket_delete',
                'display_name'  => 'Eliminar tickets',
                'description'   => 'Permite eliminar un departamento'
            ],
            [
                #'id'            => 43,
                'name'          => 'ticket_access',
                'display_name'  => 'Acceso a tickets',
                'description'   => 'Permite el acceso a la vista de tickets'
            ],
            [
                #'id'            => 44,
                'name'          => 'report_access',
                'display_name'  => 'Acceso a reportes',
                'description'   => 'Permite visualizar la seccion de reportes'
            ],
            [
                'name'          => 'log_email_show',
                'display_name'  => 'Ver Log email',
                'description'   => 'Permite ver el error del envio de correo'
            ],
            [
                'name'          => 'log_email_delete',
                'display_name'  => 'Eliminar registros del log',
                'description'   => 'Permite eliminar un registro del log'
            ],
            [
                'name'          => 'log_email_all_delete',
                'display_name'  => 'Eliminar todos los registros del log',
                'description'   => 'Permite eliminar todos los registros del log'
            ],
            [
                'name'          => 'log_email_access',
                'display_name'  => 'Acceso a log Email',
                'description'   => 'Permite el acceso a la vista de log Errors'
            ],
            [
                'name'          => 'operator_create',
                'display_name'  => 'Crear Permiso',
                'description'   => 'Permite Crear un permiso'
            ],
            [
                'name'          => 'operator_edit',
                'display_name'  => 'Editar Permiso',
                'description'   => 'Permite Editar un permiso'
            ],
            [
                'name'          => 'operator_show',
                'display_name'  => 'Ver permiso',
                'description'   => 'Permite ver el detalle de un permiso'
            ],
            [
                'name'          => 'operator_delete',
                'display_name'  => 'Eliminar permiso',
                'description'   => 'Permite Eliminar un permiso'
            ],
            [
                'name'          => 'operator_access',
                'display_name'  => 'Acceso a permisos',
                'description'   => 'Permite el acceso a la vista de permisos'
            ],
        ];

        Permission::insert($permissions);
    }
}
