<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    Use Notifiable;
    Use HasApiTokens;
    //Use SoftDeletes;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';
    const USUARIO_ADMIN = 'true';
    const USUARIO_REGULAR = 'false';

    public $transformer = UserTransformer::class;

    protected $table = 'users';
    protected $dates = ['deleted_at'];

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

    public static function generateVerificationToken()
    {
        return str_random(40);
    }

    /**Mutadores y accesores:
     * para cambiar las letras mayus a minus y hacer la transformacion fuera de la db.
     */
    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtolower($valor);
    }

    public function getNameAttribute($valor)
    {
        //return ucfirst($valor); //solo pone en mayus la primera letra
        return ucwords($valor); //pone mayus todas las primeras letras
    }


    //TODO

    public function setEmailNameAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public function esAdmin()
    {
        return $this->admin == User::USUARIO_ADMIN;
    }
}
