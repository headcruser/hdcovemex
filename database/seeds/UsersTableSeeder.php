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
                'nombre'         => 'Admin',
                'email'          => 'admin@admin.com',
                'telefono'       => '',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
            [
                'nombre'         => 'Jose Malagon',
                'email'          => 'soporteti@covemex.com',
                'telefono'       => '130',
                'password'       => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}