<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSigoTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sigo_ticket', function (Blueprint $table) {
            $table->unsignedBigInteger('ticket_id')->after('fecha');
            $table->unsignedBigInteger('operador_id')->after('ticket_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->after('operador_id')->nullable();

            $table->foreign('ticket_id', 'sigo_ticket-ticket_fk')
                ->references('id')
                ->on('tickets');

            $table->foreign('operador_id', 'sigo_ticket-operador_fk')
                ->references('id')
                ->on('usuarios');

            $table->foreign('usuario_id', 'sigo_ticket-usuario_fk')
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
        Schema::table('sigo_ticket', function (Blueprint $table) {
            $table->dropForeign('sigo_ticket-ticket_fk');
            $table->dropForeign('sigo_ticket-operador_fk');
            $table->dropForeign('sigo_ticket-usuario_fk');
        });
    }
}
