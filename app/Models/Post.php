<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

   /*  protected $guarded = []; */
    protected $fillable = ['descripcion','user_id'];

    //Relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //Relacion de uno a muchos polimorfica
    public function image(){
        return $this->morphMany('App\Models\Imagen','imageable');
    }

    //Relacion de uno a muchos
    public function comentario(){
        return $this->hasMany('App\Models\Comentario');
    }

    //Relacion de uno a muchos
    public function video(){
        return $this->hasMany('App\Models\Video');
    }

    //Relacion de uno a muchos
    public function actividades(){
        return $this->hasMany('App\Models\Actividades');
    }

    //Relacion de muchos a muchos
    /* public function actividades(){
        return $this->belongsToMany('App\Models\Actividades');
    } */
}
