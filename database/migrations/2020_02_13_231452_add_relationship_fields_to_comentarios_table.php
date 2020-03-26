<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('solicitud_id', 'comentario-solicitud_fk')
                ->references('id')
                ->on('solicitudes');

            $table->foreign('usuario_id', 'comentario-usuario_fk')
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
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign('comentario-solicitud_fk');
            $table->dropForeign('comentario-usuario_fk');
        });
    }
}
