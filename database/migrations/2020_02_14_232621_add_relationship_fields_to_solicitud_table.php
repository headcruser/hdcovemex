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
            $table->foreign('empleado_id', 'solicitud-empleado_fk')
                    ->references('id')
                    ->on('usuarios')
                    ->onUpdate('cascade');

            $table->foreign('revisado_por', 'solicitud-revision-usuario_fk')
                ->references('id')
                ->on('usuarios')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('estatus_id', 'solicitud-estatus_fk')
                ->references('id')
                ->on('statuses')
                ->onUpdate('cascade');
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
            $table->dropForeign('solicitud-empleado_fk');
            $table->dropForeign('solicitud-revision-usuario_fk');
            $table->dropForeign('solicitud-estatus_fk');
        });
    }
}
