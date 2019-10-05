<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration{

    public function up(){
        Schema::create('categorias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();

        });
        DB::table('categorias')->insert([
         'nombre' => 'alimentos',
        ]);
        DB::table('categorias')->insert([
         'nombre' => 'vestuario',
        ]);
        DB::table('categorias')->insert([
         'nombre' => 'deporte',
        ]);
        DB::table('categorias')->insert([
         'nombre' => 'recreacion',
        ]);
    }


    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
