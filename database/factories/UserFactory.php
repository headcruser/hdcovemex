<?php
namespace Database\Factories;

use Illuminate\Support\Str;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Admin\{Role, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'            => $this->faker->name(),
            'email'             => preg_replace('/@example\..*/', '@covemex.com', $this->faker->unique()->safeEmail()),
            'email_verified_at' => now(),
            'telefono'          => null,
            'usuario'           => $this->faker->username(),
            'password'          => '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', # password
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $roleEmpleado = Role::findOrFail(3);
            $user->attachRole($roleEmpleado);


            $depto = Departamento::where('nombre', '!=', 'Tecnólogias de la Información')->get()->random();
            $user->departamento()->associate($depto);
            $user->save();
        });
    }
}
