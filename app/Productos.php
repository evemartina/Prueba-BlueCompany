<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model{

    public function categorias(){
        return $this->belongsToMany(Categorias::class);
    }
}
