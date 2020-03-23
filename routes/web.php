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
        # Users
        Route::resource('usuarios', 'UsersController')->parameters([
            'usuarios' => 'user'
        ]);

        Route::resource('roles', 'RolesController')->parameters([
            'roles' => 'rol'
        ]);
    }
);
