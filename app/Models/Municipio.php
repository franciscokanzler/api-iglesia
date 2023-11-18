<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = "municipios";
    protected $primaryKey = "id";

    //Relacion de uno a muchos
    public function miembros(){
        return $this->hasMany('App\Models\Iglesia');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Estado');
    }

    public function parroquias()
    {
        return $this->hasMany('App\Models\Parroquia');
    }
}
