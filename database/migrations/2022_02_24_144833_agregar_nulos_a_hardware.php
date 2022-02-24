<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarNulosAHardware extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->dateTime('fecha_compra')->nullable()->change();
            $table->string('descripcion')->nullable()->change();
            $table->string('no_serie')->nullable()->change();
            $table->string('marca')->nullable()->change();
            $table->string('proveedor')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->unsignedBigInteger('id_tipo_hardware')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hardware', function (Blueprint $table) {
            //
        });
    }
}
