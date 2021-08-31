<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaImpresionesDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impresiones_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_impresiones')->nullable();
            $table->string('id_impresion')->nullable();
            $table->unsignedBigInteger('id_impresora')->nullable();
            $table->unsignedInteger('negro')->default(0);
            $table->unsignedInteger('color')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->timestamps();

            $table->foreign('id_impresiones')
                ->references('id')
                ->on('impresiones');

            $table->foreign('id_impresora')
                ->references('id')
                ->on('impresoras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impresiones_detalles');
    }
}
