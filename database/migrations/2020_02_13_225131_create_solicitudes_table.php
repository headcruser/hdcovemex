<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('fecha')->nullable();
            $table->unsignedBigInteger('empleado_id');
            $table->string('incidente');
            $table->binary('adjunto');
            $table->string('tipo_adjunto');
            $table->string('nombre_adjunto');
            $table->unsignedBigInteger('revisado_por')->nullable();
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
        Schema::dropIfExists('solicitudes');
    }
}
