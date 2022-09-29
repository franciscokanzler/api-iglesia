<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    use HasFactory;

    //Relacion de uno a muchos
    public function user(){
        return $this->hasMany('App\Models\User');
    }

    //Relacion de uno a muchos
    public function actividades(){
        return $this->hasMany('App\Models\Actividades');
    }

    //Relacion de uno a muchos
    public function asistencia(){
        return $this->hasMany('App\Models\Asistencia');
    }
}
