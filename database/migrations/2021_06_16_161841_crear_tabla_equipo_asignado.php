<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaEquipoAsignado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_asignado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_equipo');
            $table->dateTime('fecha_entrega');
            $table->dateTime('fecha_mantenimiento')->nullable();
            $table->string('carta_responsiva')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_asignado');
    }
}
