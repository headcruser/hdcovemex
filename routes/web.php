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


Auth::routes(['register' => false]);

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

        # SOLICITUDES
        Route::resource('solicitudes', 'SolicitudesController')->parameters([
            'solicitudes' => 'model'
        ]);

        Route::post('solicitudes/comentarios/{model}',[
            'as'            => 'solicitudes.storeComentario',
            'middleware'    => ['auth'],
            'uses'          => 'SolicitudesController@storeComment'
        ]);
    }
);

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
    }
);

# SOLICITUDES
Route::resource('solicitudes', 'SolicitudController')->parameters([
    'solicitudes' => 'model'
])->except(['edit','update','destroy']);

Route::get('solicitudes/{model}/archivo', [
    'as'            => 'solicitudes.archivo',
    'middleware'    => ['auth'],
    'uses'          => 'SolicitudController@archivo'
]);

Route::post('solicitudes/{model}/comentario', [
    'as'            => 'solicitudes.storeComentario',
    'middleware'    => ['auth'],
    'uses'          => 'SolicitudController@storeComment'
]);
