<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarCamposCredencialesACuentasPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuentas_personal', function (Blueprint $table) {
            $table->string('usuario')->nullable()->after('titulo');
            $table->string('contrasenia')->nullable()->after('usuario');
            $table->text('descripcion')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuentas_personal', function (Blueprint $table) {
            $table->dropColumn(['usuario','contrasenia']);
            $table->string('descripcion')->change();
        });
    }
}
