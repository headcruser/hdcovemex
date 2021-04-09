<?php

namespace Database\Factories;

use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\SigoTicket;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = optional(User::withRole('soporte')->get()->random())->id;

        return [
            'fecha'         => now(),
            'privado'       => $this->faker->randomElement(Config::get('helpdesk.global.visibilidad.values', [])),
            'operador_id'   => $user,
            'usuario_id'    => $user,
            'contacto'      => $this->faker->randomElement(Config::get('helpdesk.tickets.contacto.values', [])),
            'prioridad'     => $this->faker->randomElement(array_keys(Config::get('helpdesk.tickets.prioridad.values', []))),
            'titulo'        => $this->faker->sentence(2),
            'incidente'     => $this->faker->text(),
            'proceso'       => $this->faker->randomElement(Config::get('helpdesk.tickets.proceso.values')),
            'tipo'          => $this->faker->randomElement(array_keys(Config::get('helpdesk.tickets.tipo.values'))),
            'sub_tipo'      => '',
            'estado'        => $this->faker->randomElement(['Abierto', 'Cancelado', 'Finalizado']),
            'asignado_a'    => optional(User::withRole('soporte')->get()->random())->id
        ];
    }

    public function comentario()
    {
        return $this->afterCreating(function (Ticket $ticket) {
            $comentario = new SigoTicket([
                'operador_id'   => $ticket->usuario_id,
                'usuario_id'    => null,
                'fecha'         => now(),
                'comentario'    => $this->faker->text(),
                'visible'       => 'S',
            ]);

            $ticket->sigoTicket()->save($comentario);
        });
    }
}
