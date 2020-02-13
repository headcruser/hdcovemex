<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoRolPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_rol', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_pr')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedInteger('permission_id');
            $table->foreign('permission_id', 'permission_id_fk_pr')->references('id')->on('permisos')->onDelete('cascade');
        });
    }
}
