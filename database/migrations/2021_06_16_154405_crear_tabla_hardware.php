<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaHardware extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_compra');
            $table->string('descripcion');
            $table->string('no_serie');
            $table->string('marca');
            $table->string('proveedor');
            $table->string('status');
            $table->boolean('asignado')->default(false);
            $table->unsignedBigInteger('id_tipo_hardware');
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
        Schema::dropIfExists('hardware');
    }
}
