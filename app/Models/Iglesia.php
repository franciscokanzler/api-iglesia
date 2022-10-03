<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    use HasFactory;

    protected $guarded = [];//se agregan campos protegidos

    //Relacion de uno a muchos
    public function miembros(){
        return $this->hasMany('App\Models\Miembros');
    }

    //Relacion de uno a muchos
    public function equipos(){
        return $this->hasMany('App\Models\Equipo');
    }
}
