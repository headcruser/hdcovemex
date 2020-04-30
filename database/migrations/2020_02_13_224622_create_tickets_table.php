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
            $table->timestamp('fecha')->nullable();
            $table->enum('privado', ['S', 'N'])->default('S');

            $table->string('contacto',20);
            $table->smallInteger('prioridad');
            $table->string('titulo',50);
            $table->text('incidente');

            $table->string('proceso',20);
            $table->string('tipo',20);
            $table->string('sub_tipo',20);
            $table->string('estado',20);

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
