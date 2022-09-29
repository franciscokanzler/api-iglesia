<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    use HasFactory;

    //Relacion de uno a muchos
    public function miembros(){
        return $this->hasMany('App\Models\Miembros');
    }

    //Relacion de muchos a muchos
    public function equipos(){
        return $this->belongsToMany('App\Models\Equipo');
    }
}
