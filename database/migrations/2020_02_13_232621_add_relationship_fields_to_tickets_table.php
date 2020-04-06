<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('operador_id')->nullable()->after('privado');
            $table->unsignedBigInteger('usuario_id')->nullable()->after('operador_id');
            $table->unsignedBigInteger('asignado_a')->nullable('usuario_id');

            $table->foreign('usuario_id', 'tiket-usuario_fk')
                ->references('id')
                ->on('usuarios');

            $table->foreign('asignado_a', 'tiket-usuario-asignado_fk')
                ->references('id')
                ->on('usuarios');

            $table->foreign('operador_id', 'tiket-usuario-operador_fk')
                ->references('id')
                ->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tiket-usuario_fk');
            $table->dropForeign('tiket-usuario-asignado_fk');
            $table->dropForeign('tiket-usuario-operador_fk');
        });
    }
}
