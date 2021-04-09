<?php
namespace Database\Seeders;

use HelpDesk\Entities\Admin\Operador;
use HelpDesk\Entities\Admin\User;
use Illuminate\Database\Seeder;

class OperatorSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operadores = User::withRoles('soporte', 'jefatura')->get();

        foreach ($operadores as $operador) {
            Operador::create([
                'usuario_id'            => $operador->id,
                'notificar_solicitud'   => true,
                'notificar_asignacion'  => true,
            ]);
        }
    }
}
