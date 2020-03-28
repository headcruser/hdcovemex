<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('titulo');
            $table->string('incidente');
            $table->binary('adjunto')->nullable();
            $table->string('tipo_adjunto')->nullable();
            $table->string('nombre_adjunto')->nullable();
            $table->unsignedBigInteger('revisado_por')->nullable();
            $table->unsignedSmallInteger('estatus_id');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE solicitudes MODIFY adjunto MEDIUMBLOB"); # MYSQL
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
