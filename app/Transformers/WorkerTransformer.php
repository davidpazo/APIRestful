<?php

namespace App\Transformers;

use App\Worker;
use League\Fractal\TransformerAbstract;

class WorkerTransformer extends TransformerAbstract
{
    public static function originalAttribute($index)
    {
        $attributes = [
            'empleadoID' => 'id',
            'empleadoNombre' => 'name',
            'empleadoCorreo' => 'email',
            'fechaInicio' => 'date_in',
            'fechaFin' => 'date_out',
            'departamento' => 'position',
            'departamentoID' => 'dep_id',
            'estado' => 'status',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'empleadoID',
            'name' => 'empleadoNombre',
            'email' => 'empleadoCorreo',
            'date_in' => 'fechaInicio',
            'date_out' => 'fechaFin',
            'position' => 'departamento',
            'dep_id' => 'departamentoID',
            'status' => 'estado',
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
    public function transform(Worker $worker)
    {
        return [
            'empleadoID' => (int)$worker->id,
            'empleadoNombre' => (string)$worker->name,
            'empleadoCorreo' => (string)$worker->email,
            'fechaInicio' => (string)$worker->date_in,
            'fechaFin' => (string)$worker->date_out,
            'departamento' => (int)$worker->position,
            'departamentoID' => (int)$worker->dep_id,
            'estado' => (int)$worker->status,
            'fechaCreacion' => $worker->created_at,
            'fechaActualizacion' => $worker->updated_at,
            //'fechaEliminacion'=> isset($worker->deleted_at)?(string) $worker-> deleted_at : null,
            'links' => [[
                'rel' => 'self',
                'href' => route('workers.show', $worker->id),
            ], [
                'rel' => 'workers.departments',
                'href' => route('workers.departments.index', $worker->id)
            ]
            ]

        ];
    }
}
