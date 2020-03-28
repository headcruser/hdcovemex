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
                'nombre'         => 'Juan Carlos Aguilar Patiño',
                'email'          => 'admin@admin.com',
                'telefono'       => null,
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Jose Malagon',
                'email'          => 'soporte@covemex.com',
                'telefono'       => '113',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Mayra Martinez Tovar',
                'email'          => 'empleado@covemex.com',
                'telefono'       => '135',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
