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
            $table->foreign('estatus_id', 'eticket_fk')->references('id')->on('estatus');
            $table->foreign('prioridad_id', 'pticket_fk')->references('id')->on('prioridades');
            $table->foreign('categoria_id', 'cticket_fk')->references('id')->on('categorias');
            $table->foreign('solicitud_id', 'sticket_fk')->references('id')->on('solicitudes');
        });
    }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign('eticket_fk');
            $table->dropForeign('pticket_fk');
            $table->dropForeign('cticket_fk');
            $table->dropForeign('sticket_fk');
        });
    }
}
