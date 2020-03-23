<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolUsuarioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_rol', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');

            $table->foreign('user_id', 'user_id_fk_ur')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('role_id', 'role_id_fk_ur')->references('id')->on('roles')->onDelete('cascade');
        });
    }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_rol', function (Blueprint $table) {
            $table->dropForeign('user_id_fk_ur');
            $table->dropForeign('role_id_fk_ur');
        });

        Schema::dropIfExists('usuario_rol');
    }
}
