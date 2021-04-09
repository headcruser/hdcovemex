<?php

namespace Database\Factories;

use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Admin\Operador;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperadorFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Operador::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $operadores = User::withRoles('soporte', 'jefatura')->get();
        $operador = $operadores->random();

        return [
            'usuario_id'            => $operador->id,
            'notificar_solicitud'   => true,
            'notificar_asignacion'  => true,
        ];
    }
}
