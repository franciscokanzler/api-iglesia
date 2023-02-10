<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Relacion de uno a muchos
    public function user(){
        return $this->hasMany('App\Models\User');
    }

    //Relacion de uno a muchos inversa
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

}
