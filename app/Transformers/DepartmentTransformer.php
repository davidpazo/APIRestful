<?php

namespace App\Transformers;

use App\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    public static function originalAttribute($index)
    {
        $attributes = [
            'departamentoID' => 'id',
            'nombre' => 'name',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'departamentoID',
            'name' => 'nombre',
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
    public function transform(Department $department)
    {
        return [
            'departamentoID' => (int)$department->id,
            'NombreDepartamento' => (string)$department->name,
            //'fechaCreacion'=> $user->created_at,
            //'fechaActualizacion'=> $user->updated_at,
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
            /** HATEOAS,  sirve para generar enlaces entre diferentes recursos de nuestra app
             * enlaces de navegacion */
            'links' => [[
                'rel' => 'self',
                'href' => route('departments.show', $department->id),
            ], [
                'rel' => 'departments.workers',
                'href' => route('departments.workers.index', $department->id)
            ]
            ]
        ];
    }
}
