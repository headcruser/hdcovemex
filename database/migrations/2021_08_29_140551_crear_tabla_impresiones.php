<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaImpresiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impresiones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->smallInteger('mes');
            $table->unsignedInteger('anio');
            $table->unsignedInteger('negro')->default(0);
            $table->unsignedInteger('color')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('creado_por')->nullable();
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
        Schema::dropIfExists('impresiones');
    }
}
