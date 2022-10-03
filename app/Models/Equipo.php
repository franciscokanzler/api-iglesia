<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Relacion de muchos a muchos
    public function miembros(){
        return $this->belongsToMany('App\Models\Miembros');
    }

    //Relacion de uno a muchos inversa
    public function iglesia(){
        return $this->belongsTo('App\Models\Iglesia');
    }
}
