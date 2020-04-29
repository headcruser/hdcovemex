<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')
    ->middleware('auth')
    ->name('home');

Route::get('perfil',[
    'as'            => 'perfil',
    'middleware'    =>['auth'],
    'uses'          => 'ProfileController@edit'
]);

Route::post('perfil',[
    'as'            => 'perfil.store',
    'middleware'    =>['auth'],
    'uses'          => 'ProfileController@store'
]);


Route::get('notificaciones', [
    'as'            => 'notificaciones',
    'middleware'    => ['auth'],
    'uses'          => 'HomeController@notificaciones'
]);

Route::post('notificaciones', [
    'as'            => 'notificaciones.delete',
    'middleware'    =>['auth'],
    'uses'          => 'HomeController@deleteNotifications'
]);

# AUTENTICATION
Auth::routes([
    'register' => false
]);

# ADMINISTRACION
Route::group([
    'prefix'        => 'administracion',
    'as'            => 'admin.',
    'namespace'     => 'Admin',
    'middleware'    => ['auth']],
    function () {
        # USUARIOS
        Route::resource('usuarios', 'UsersController')->parameters([
            'usuarios'  => 'model'
        ]);

        # ROLES
        Route::resource('roles', 'RolesController')->parameters([
            'roles' => 'model'
        ]);

        # PERMISOS
        Route::resource('permisos', 'PermisosController')->parameters([
            'permisos' => 'model'
        ]);

        # DEPARTAMENTOS
        Route::resource('departamentos', 'DepartamentsController')->parameters([
            'departamentos'  => 'model'
        ]);


    }
);

# OPERADOR
Route::group([
    # 'prefix'        => 'administracion',
    'as'            => 'operador.',
    'namespace'     => 'Operador',
    'middleware'    => ['auth']],
    function () {

        # SOLICITUDES
        Route::resource('gestion-solicitudes', 'SolicitudesController')->parameters([
            'gestion-solicitudes' => 'model'
        ]);

        # TICKETS
        Route::resource('tickets', 'TicketController')->parameters([
            'tickets' => 'model'
        ]);

        Route::post('tickets/comentarios/{model}',[
            'as'            => 'tickets.storeComentario',
            'middleware'    => ['auth'],
            'uses'          => 'TicketController@storeComment'
        ]);
    }
);

# CONFIGURACION
Route::group([
    'prefix'        => 'configuracion',
    'as'            => 'config.',
    'namespace'     => 'Config',
    'middleware'    => ['auth']],
    function () {
        # ATRIBUTOS
        Route::resource('atributos', 'AttributesController')->parameters([
            'atributos' => 'model'
        ]);

        # ESTATUS
        Route::resource('estatus', 'StatusesController')->parameters([
            'estatus' => 'model'
        ]);
    }
);


# USUARIO
Route::group([
    'namespace' => 'Usuario',
],function () {

    # SOLICITUDES (EMPLEADO)
    Route::resource('solicitudes', 'SolicitudController')->parameters([
        'solicitudes' => 'model'
    ])->except(['edit','update','destroy']);

    # ARCHIVO ADJUNTO SOLICITUD
    Route::get('solicitudes/{model}/archivo', [
        'as'            => 'solicitudes.archivo',
        'middleware'    => ['auth'],
        'uses'          => 'SolicitudController@archivo'
    ]);

    # COMENTARIO SOLICITUD
    Route::post('solicitudes/{model}/comentario', [
        'as'            => 'solicitudes.storeComentario',
        'middleware'    => ['auth'],
        'uses'          => 'SolicitudController@storeComment'
    ]);
});
