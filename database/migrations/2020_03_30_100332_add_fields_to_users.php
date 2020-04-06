<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('usuario', 20)->unique()->after('password')->nullable();
            $table->binary('foto')->after('usuario')->nullable();
            $table->string('tipo_foto')->after('foto')->nullable();
            $table->string('nombre_foto')->after('tipo_foto')->nullable();
        });

        DB::statement("ALTER TABLE usuarios MODIFY foto MEDIUMBLOB"); # MYSQL
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('usuario');
            $table->dropColumn('foto');
            $table->dropColumn('tipo_foto');
            $table->dropColumn('nombre_foto');
        });
    }
}
