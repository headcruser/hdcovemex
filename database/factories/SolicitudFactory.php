<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Solicitude;
use HelpDesk\Entities\Config\Status;
use Illuminate\Support\Facades\Config;

class SolicitudFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solicitude::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fecha'         => now(),
            'usuario_id'    => optional(User::withRole('empleado')->get()->random())->id,
            'estatus_id'    => optional(Status::pendientes()->first())->id,
            'titulo'        => $this->faker->sentence(2),
            'incidente'     => $this->faker->text(),
        ];
    }

    public function createTicket()
    {
        return $this->afterCreating(function (Solicitude $solicitud) {
            $ticket = Ticket::factory()->comentario()->create([
                'titulo'        => 'Atentiendo Solicitud ' . $solicitud->id,
                'usuario_id'    => $solicitud->usuario_id,
                'incidente'     => $solicitud->incidente,
                'estado'        => Config::get('helpdesk.tickets.estado.alias.ABT'),
            ]);

            $solicitud->ticket()->associate($ticket);
            $solicitud->estatus_id = optional(Status::proceso()->first())->id;
            $solicitud->save();
        });
    }
}
