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
            $table->unsignedInteger('user_id');

            $table->foreign('user_id', 'user_id_fk_ur')->references('id')->on('usuarios')->onDelete('cascade');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_ur')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
