<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $guarded = ['file'];

    //Relacion de uno a muchos inversa
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

}
