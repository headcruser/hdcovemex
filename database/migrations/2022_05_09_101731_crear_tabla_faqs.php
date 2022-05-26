<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFaqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('faqs')){
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('pregunta')->nullable();
                $table->string('slug')->nullable();
                $table->longText('respuesta')->nullable();
                $table->unsignedInteger('total_lecturas')->default(0);
                $table->unsignedInteger('ayuda_si')->default(0);
                $table->unsignedInteger('ayuda_no')->default(0);
                $table->unsignedBigInteger('id_categoria_faq')->nullable();
                $table->unsignedInteger('orden')->nullable()->index();
                $table->boolean('visible')->nullable();
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('id_categoria_faq')->references('id')->on('faq_categorias')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}
