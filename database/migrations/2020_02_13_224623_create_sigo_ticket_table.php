<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSigoTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigo_ticket', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('fecha')->nullable();

            $table->string('campo_cambiado',30)->nullable();
            $table->string('valor_anterior',60)->nullable();
            $table->string('valor_actual',60)->nullable();

            $table->text('comentario');
            $table->enum('privado', ['S', 'N'])->default('N');

            # ARCHIVO ADJUNTO
            $table->binary('adjunto')->nullable();
            $table->string('tipo_adjunto')->nullable();
            $table->string('nombre_adjunto')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE sigo_ticket MODIFY adjunto MEDIUMBLOB"); # MYSQL
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sigo_ticket');
    }
}
