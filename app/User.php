<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';
    const USUARIO_ADMIN ='true';
    const USUARIO_REGULAR = 'false';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'department',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];
    /**Mutadores y accesores:
     * para cambiar las letras mayus a minus y hacer la transformacion fuera de la db.
     */
    public function setNameAttribute($valor){
        $this -> attributes['name']= strtolower($valor);
    }
    public function getNameAttribute($valor){
        //return ucfirst($valor); //solo pone en mayus la primera letra
        return ucwords($valor); //pone mayus todas las primeras letras
    }
    public function setEmailNameAttribute($valor){
        $this -> attributes['email']= strtolower($valor);
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];
    //TODO
    public function esVerificado()
{
        return $this-> verified == User::USUARIO_VERIFICADO;
    }
    public function esAdmin()
{
    return $this-> admin == User::USUARIO_ADMIN;
}
    public static function generateVerificationToken()
{
    return str_random(40);
}
}
