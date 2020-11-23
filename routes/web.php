<?php

/*
|--------------------------------------------------------------------------
| Web Routes (HDCOVEMEX)
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

# DASHBOARD
Route::get('/', 'HomeController@index')
    ->middleware('auth')
    ->name('home');

# PERFIL
Route::group([
    'prefix'        => 'perfil',
    'middleware'    => ['auth']],
    function () {
        Route::get('/',[
            'as'    => 'perfil',
            'uses'  => 'ProfileController@edit'
        ]);

        Route::post('/',[
            'as'    => 'perfil.store',
            'uses'  => 'ProfileController@store'
        ]);
    }
);

# NOTIFICACIONES
Route::group([
    'prefix'        => 'notificaciones',
    'middleware'    => ['auth']],
    function () {

        Route::get('/', [
            'as'    => 'notificaciones',
            'uses'  => 'HomeController@notificaciones'
        ]);

        Route::post('/', [
            'as'    => 'notificaciones.delete',
            'uses'  => 'HomeController@deleteNotifications'
        ]);
    }
);


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

        # LOG EMAIL
        Route::delete('log-email/destroy', 'LogEmailController@massDestroy')->name('log-email.masive-destroy');

        Route::resource('log-email', 'LogEmailController')->parameters([
            'log-email' => 'logEmail'
        ])->only(['index','show','destroy']);

        # OPERADORES
        Route::resource('operadores', 'OperatorsController')->parameters([
            'operadores'  => 'operador'
        ]);
    }
);

# OPERADOR
Route::group([
    'as'            => 'operador.',
    'namespace'     => 'Operador',
    'middleware'    => ['auth']],
    function () {

        # SOLICITUDES
        Route::resource('gestion-solicitudes', 'SolicitudesController')->parameters([
            'gestion-solicitudes' => 'model'
        ]);

        # ARCHIVO ADJUNTO SOLICITUD
        Route::get('gestion-solicitudes/{model}/archivo', [
            'as'            => 'gestion-solicitudes.archivo',
            'uses'          => 'SolicitudesController@archivo'
        ]);

        # TICKETS
        Route::resource('tickets', 'TicketController')->parameters([
            'tickets' => 'model'
        ]);

        Route::post('tickets/comentarios/{model}',[
            'as'            => 'tickets.storeComentario',
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
    'namespace'     => 'Usuario',
    'middleware'    => ['auth'],
],function () {

    # SOLICITUDES (EMPLEADO)
    Route::resource('solicitudes', 'SolicitudController')->parameters([
        'solicitudes' => 'model'
    ])->except(['edit','update','destroy']);

    # ARCHIVO ADJUNTO SOLICITUD
    Route::get('solicitudes/{model}/archivo', [
        'as'            => 'solicitudes.archivo',
        'uses'          => 'SolicitudController@archivo'
    ]);

    # COMENTARIO SOLICITUD
    Route::post('solicitudes/{model}/comentario', [
        'as'            => 'solicitudes.storeComentario',
        'uses'          => 'SolicitudController@storeComment'
    ]);
});

# REPORTES
Route::group([
    'prefix'        => 'reportes',
    'as'            => 'reporte.',
    'namespace'     => 'Reportes',
    'middleware'    => ['auth']
], function () {
    Route::get('eficiencia/export', [
        'as'    => 'eficiencia.export',
        'uses'  => 'EficienciaReportController@export'
    ]);

    Route::get('eficiencia', [
        'as'    => 'eficiencia',
        'uses'  => 'EficienciaReportController@eficiencia'
    ]);
});


# HERRAMIENTAS

Route::group([
    'prefix'        => 'herramientas',
    'as'            => 'herramientas.',
    'namespace'     => 'Herramientas',
    'middleware'    => ['auth']],
    function () {
        Route::get('barcode', [
            'as'            => 'barcode.index',
            'uses'          => 'BarcodeController@index'
        ]);

        Route::get('barcode/download', [
            'as'            => 'barcode.download',
            'uses'          => 'BarcodeController@download'
        ]);
    }
);
