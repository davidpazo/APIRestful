<?php

namespace App;

use App\Transformers\VacationTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacation extends Model
{
    public $transformer = VacationTransformer::class;

    const FECHA_DISPONIBLE = 'disponible';
    const FECHA_NO_DISPONIBLE = 'no disponible';

    //use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }
    //Funcion para saber si la fecha esta disponible.
    public function estaDisponible()
    {
        return $this->status == Vacation::FECHA_DISPONIBLE;
    }
}
