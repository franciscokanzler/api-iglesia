<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    use HasFactory;

    protected $table = "parroquias";
    protected $primaryKey = "id";

    //Relacion de uno a muchos
    public function miembros(){
        return $this->hasMany('App\Models\Iglesia');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Models\Municipio');
    }
}
