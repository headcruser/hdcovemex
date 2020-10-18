<?php


use HelpDesk\Entities\Admin\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nombre'         => 'Administrador',
                'email'          => 'admin@admin.com',
                'telefono'       => null,
                'usuario'        => 'admin',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Juan Carlos Aguilar Patiño',
                'email'          => 'ti@covemex.com',
                'telefono'       => '128',
                'usuario'        => '165',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Jose Malagon Martinez Lopez',
                'email'          => 'soporte@covemex.com',
                'telefono'       => '113',
                'usuario'        => '7078',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Daniel Martinez Sierra',
                'email'          => 'programacion@covemex.com',
                'telefono'       => null,
                'usuario'        => '8097',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Mayra Martinez Tovar',
                'email'          => 'capacitacion.rh@covemex.com',
                'telefono'       => '135',
                'usuario'        => '6768',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Mariela Elizabeth Gomez Martinez',
                'email'          => 'produccion.supervision@covemex.com',
                'telefono'       => null,
                'usuario'        => '7368',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
