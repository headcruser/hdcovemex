<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->after('fecha');
            $table->unsignedBigInteger('ticket_id')->nullable()->after('usuario_id');
            $table->unsignedSmallInteger('estatus_id')->after('ticket_id');

            $table->foreign('usuario_id', 'solicitud-usuario_fk')
                    ->references('id')
                    ->on('usuarios');

            $table->foreign('estatus_id', 'solicitud-estatus_fk')
                ->references('id')
                ->on('statuses');

            $table->foreign('ticket_id', 'solicitud-ticket_fk')
                ->references('id')
                ->on('tickets');
        });
    }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropForeign('solicitud-usuario_fk');
            $table->dropForeign('solicitud-estatus_fk');
            $table->dropForeign('solicitud-ticket_fk');
        });
    }
}
