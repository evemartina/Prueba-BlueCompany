<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration{

    public function up(){
        Schema::create('productos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->integer('valor');
            $table->dateTime('fecha_expiracion')->nullable();
            $table->timestamps();

        });
    }


    public function down() {
        Schema::dropIfExists('productos');
    }
}
