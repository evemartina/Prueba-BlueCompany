<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasProductosTable extends Migration{

    public function up(){
         Schema::create('categorias_productos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('productos_id')->nullable();
            $table->unsignedInteger('categorias_id')->nullable();
            $table->foreign('categorias_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('productos_id')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();

        });
    }


    public function down(){
        Schema::dropIfExists('categorias_productos');
    }
}
