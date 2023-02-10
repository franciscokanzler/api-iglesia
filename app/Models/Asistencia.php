<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Relacion de uno a muchos inversa
    public function actividad(){
        return $this->belongsTo('App\Models\Actividades');
    }

    //Relacion de uno a muchos inversa
    public function estatus(){
        return $this->belongsTo('App\Models\Estatus');
    }

    //Relacion de uno a muchos inversa
    public function miembro(){
        return $this->belongsTo('App\Models\miembros');
    }

}
