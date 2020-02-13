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
            $table->foreign('solicitud_id', 'scomentario_fk')->references('id')->on('solicitudes');
            $table->foreign('usuario_id', 'ucomentario_fk')->references('id')->on('usuarios');
        });
    }
}
