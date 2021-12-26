<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaCredenciales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('credenciales')) {
            Schema::create('credenciales', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->text('url');
                $table->string('usuario')->nullable();
                $table->string('contrasenia')->nullable();
                $table->text('nota')->nullable();
                $table->boolean('caducidad')->nullable();
                $table->unsignedBigInteger('id_usuario')->nullable();
                $table->timestamps();

                $table->foreign('id_usuario')
                ->references('id')
                ->on('usuarios');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credenciales');
    }
}
