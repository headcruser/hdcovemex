<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->datetime('email_verified_at')->nullable();

            $table->string('telefono')->nullable();

            if (DB::getDriverName() !== 'sqlsrv') {
                $table->unique('telefono', 'users_telefono_unique');
            }

            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->unsignedInteger('departamento_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        # supports index SQL SERVER
        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement('CREATE UNIQUE INDEX users_telefono_unique'
               . ' ON usuarios (telefono)'
               . ' WHERE telefono IS NOT NULL');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
