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
