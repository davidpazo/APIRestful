<?php
/**
 * Created by PhpStorm.
 * User: dpazo
 * Date: 20/11/2017
 * Time: 10:25
 */

namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WorkerScope implements Scope
{
    //forma de limitar o generar la excepcion para que devuelva solo los trabajadores que tengan departamentos.
    public function apply(Builder $builder, Model $model)
    {
        $builder->has('departments');
    }
}