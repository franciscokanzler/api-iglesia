<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    //Relacion de uno a muchos
    public function actividades(){
        return $this->hasMany('App\Models\Actividades');
    }
}
