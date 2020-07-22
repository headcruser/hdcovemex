<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->boolean('notificar_solicitud');
            $table->boolean('notificar_asignacion');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usuario_id', 'operador-usuario_fk')
                ->references('id')
                ->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operadores', function (Blueprint $table) {
            $table->dropForeign('operador-usuario_fk');
        });

        Schema::dropIfExists('operadores');
    }
}
