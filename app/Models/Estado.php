<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    //Relacion de uno a muchos
    public function miembros(){
        return $this->hasMany('App\Models\Iglesia');
    }
}
