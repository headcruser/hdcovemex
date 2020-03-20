<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('contenido');
            $table->string('autor_nombre');
            $table->string('autor_email');
            $table->unsignedBigInteger('asignado_a');
            $table->unsignedSmallInteger('estatus_id');
            $table->unsignedSmallInteger('prioridad_id');
            $table->unsignedSmallInteger('categoria_id');
            $table->unsignedBigInteger('solicitud_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
