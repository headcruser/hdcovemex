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
            $table->string('observacion');
            $table->binary('adjunto');
            $table->string('tipo_adjunto');
            $table->string('nombre_adjunto');
            $table->unsignedBigInteger('solicitud_id');
            $table->unsignedBigInteger('asignado_a');
            $table->unsignedSmallInteger('prioridad_id');
            $table->unsignedSmallInteger('proceso_id');
            $table->unsignedSmallInteger('tipo_id');
            $table->unsignedSmallInteger('estatus_id');
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
