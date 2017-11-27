<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public static function originalAttribute($index)
    {
        $attributes = [
            'userID' => 'id',
            'nombre' => 'name',
            'correo' => 'email',
            'Verificado' => 'verified',
            'Administrador' => 'admin',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'userID',
            'name' => 'nombre',
            'email' => 'correo',
            'verified' => 'Verificado',
            'admin' => 'Administrador',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * A Fractal transformer.
     * para ocultar datos de la base de datos
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'userID' => (int)$user->id,
            'nombre' => (string)$user->name,
            'correo' => (string)$user->email,
            'Verificado' => (int)$user->verified,
            'Administrador' => ($user->admin === 'true'),
            'fechaCreacion' => $user->created_at,
            'fechaActualizacion' => $user->updated_at,
            //'fechaEliminacion'=> isset($user->deleted_at)?(string) $user-> deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show', $user->id),
                ],
            ],
        ];
    }


}
