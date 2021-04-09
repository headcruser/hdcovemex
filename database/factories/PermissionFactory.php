<?php
namespace Database\Factories;

use Illuminate\Support\Str;
use HelpDesk\Entities\Admin\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => Str::snake($this->faker->lexify('Permission ???')),
            'display_name'  => $this->faker->unique()->sentence(2),
            'description'   => $this->faker->sentence(5)
        ];
    }
}
