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
            $table->foreign('solicitud_id', 'tiket-solicitud_fk')
                ->references('id')
                ->on('solicitudes')
                ->onUpdate('cascade');

            $table->foreign('prioridad_id', 'tiket-attibutes_fk')
                ->references('id')
                ->on('attributes')
                ->onUpdate('cascade');

            $table->foreign('estatus_id', 'tiket-estatus_fk')
                ->references('id')
                ->on('attributes')
                ->onUpdate('cascade');

            $table->foreign('proceso_id', 'proceso-attributes_fk')
                ->references('id')
                ->on('attributes')
                ->onUpdate('cascade');

            $table->foreign('tipo_id', 'tipo-attributes_fk')
                ->references('id')
                ->on('attributes')
                ->onUpdate('cascade');

            $table->foreign('asignado_a', 'tiket-usuario-soporte_fk')
                ->references('id')
                ->on('solicitudes')
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
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tiket-solicitud_fk');
            $table->dropForeign('tiket-attibutes_fk');
            $table->dropForeign('tiket-estatus_fk');
            $table->dropForeign('proceso-attributes_fk');
            $table->dropForeign('tipo-attributes_fk');
            $table->dropForeign('tiket-usuario-soporte_fk');
        });
    }
}
