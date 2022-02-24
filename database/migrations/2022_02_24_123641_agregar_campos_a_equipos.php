<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarCamposAEquipos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('descripcion')->nullable()->change();
            $table->string('tipo')->nullable()->after('descripcion');
            $table->string('marca')->nullable()->after('tipo');
            $table->string('modelo')->nullable()->after('marca');
            $table->string('no_serie')->nullable()->after('modelo');
            $table->string('sistema_operativo')->nullable()->after('no_serie');
            $table->string('procesador')->nullable()->after('sistema_operativo');
            $table->string('memoria')->nullable()->after('procesador');
            $table->string('almacenamiento')->nullable()->after('memoria');
            $table->date('fecha_compra')->nullable()->after('almacenamiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn([
                'tipo',
                'marca',
                'modelo',
                'no_serie',
                'sistema_operativo',
                'procesador',
                'memoria',
                'almacenamiento',
                'fecha_compra',
            ]);
        });
    }
}
