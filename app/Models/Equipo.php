<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    //Relacion de muchos a muchos
    public function miembros(){
        return $this->belongsToMany('App\Models\Miembros');
    }

    //Relacion de muchos a muchos
    public function iglesia(){
        return $this->belongsToMany('App\Models\Iglesia');
    }
}
