<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Relacion de uno a uno inverso
    public function miembro(){
        return $this->belongsTo('App\Models\Miembro');
    }

    //Relacion de uno a muchos inversa
    public function role(){
        return $this->belongsTo('App\Models\Role');
    }

    //Relacion de uno a uno inverso
    public function imagen(){
        return $this->belongsTo('App\Models\Imagen');
    }

    //Relacion de uno a muchos inversa
    public function estatus(){
        return $this->belongsTo('App\Models\Estatus');
    }

    //Relacion de uno a muchos
    public function post(){
        return $this->hasMany('App\Models\Post');
    }

    //Relacion de uno a uno polimorfica
    public function image(){
        return $this->morphOne('App\Models\Imagen','imageable');
    }

    //Relacion de uno a muchos inversa
    public function comentario(){
        return $this->belongsTo('App\Models\Comentario');
    }
}
