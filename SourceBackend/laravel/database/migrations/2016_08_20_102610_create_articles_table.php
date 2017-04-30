<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->text('titulo');
            $table->string('autor');
            $table->date('fecha');
            $table->string('ruta_imagen');
            $table->text('contenido');                    
            $table->integer('cantidad_visitas');
            $table->integer('cantidad_me_gusta');
            $table->integer('cantidad_no_me_gusta');
            $table->string('ruta');
            //$table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
