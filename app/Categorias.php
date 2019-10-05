<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model{

    public function productos()    {
        return $this->belongsToMany(Productos::class);
    }
}
