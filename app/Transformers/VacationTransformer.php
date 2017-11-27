<?php

namespace App\Transformers;

use App\Vacation;
use League\Fractal\TransformerAbstract;

class VacationTransformer extends TransformerAbstract
{
    public static function originalAttribute($index)
    {
        $attributes = [
            'vacationID' => 'id',
            'cantidadDias' => 'daysTaken',
            'razon' => 'reason',
            'comentarios' => 'observations',
            'tipo' => 'type',
            'fechaInicio' => 'date_init',
            'empleadoID' => 'worker_id',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'vacationID',
            'daysTaken' => 'cantidadDias',
            'reason' => 'razon',
            'observations' => 'comentarios',
            'type' => 'tipo',
            'date_init' => 'fechaInicio',
            'worker_id' => 'empleadoID',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Vacation $vacation)
    {
        return [
            'vacationID' => (int)$vacation->id,
            'cantidadDias' => (int)$vacation->daysTaken,
            'razon' => (string)$vacation->reason,
            'comentarios' => (int)$vacation->observations,
            'tipo' => (string)$vacation->type,
            'fechaInicio' => (string)$vacation->date_init,
            'empleadoID' => (int)$vacation->worker_id,
            'fechaCreacion' => $vacation->created_at,
            'fechaActualizacion' => $vacation->updated_at,
            //'fechaEliminacion'=> isset($worker->deleted_at)?(string) $worker-> deleted_at : null,
        ];
    }

}
