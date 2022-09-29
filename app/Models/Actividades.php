<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    use HasFactory;

    //Relacion de uno a muchos inversa
    public function categorias(){
        return $this->belongsTo('App\Models\Categorias');
    }

    //Relacion de muchos a muchos
    public function post(){
        return $this->belongsToMany('App\Models\Post');
    }

     //Relacion de uno a muchos inversa
     public function estatus(){
        return $this->belongsTo('App\Models\Estatus');
    }

    //Relacion de uno a muchos
    public function asistencia(){
        return $this->hasMany('App\Models\Asistencia');
    }
}
