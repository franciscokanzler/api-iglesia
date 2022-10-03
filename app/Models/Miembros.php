<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembros extends Model
{
    use HasFactory;

    //Relacion de uno a muchos inversa
    public function iglesia(){
        return $this->belongsTo('App\Models\Iglesia');
    }

    //Relacion de uno a muchos inversa
    public function rango(){
        return $this->belongsTo('App\Models\Rango');
    }

    //Relacion de uno a muchos inversa
    public function estado_civil(){
        return $this->belongsTo('App\Models\EstadoCivil');
    }

    //Relacion de uno a muchos inversa
    public function estado(){
        return $this->belongsTo('App\Models\Estado');
    }

    //Relacion de uno a muchos inversa
    public function municipio(){
        return $this->belongsTo('App\Models\Municipio');
    }

    //Relacion de uno a muchos inversa
    public function parroquia(){
        return $this->belongsTo('App\Models\Parroqui');
    }

    //Relacion de muchos a muchos
    public function equipos(){
        return $this->belongsToMany('App\Models\Equipo');
    }

    //Relacion de uno a uno
    public function user(){
        return $this->hasOne('App\Models\User');
    }

    //Relacion de uno a muchos
    public function asistencia(){
        return $this->hasMany('App\Models\Asistencia');
    }
}
