<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            DepartamentoTableSeeder::class,
            UsersTableSeeder::class,
            UserDeptoTableSeeder::class,
            RoleUserTableSeeder::class,
            PermissionTableSeeder::class,
            PermissionRoleTableSeeder::class,
            AttributeTableSeeder::class,
            StatusesTableSeeder::class,
            OperatorSeeders::class,
            TipoHardwareSeeder::class,
            SucursalSeeder::class,
            ImpresoraSeeder::class,
        ]);
    }
}
