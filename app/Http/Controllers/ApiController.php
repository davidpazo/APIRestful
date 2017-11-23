<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class ApiController extends Controller
{
    use ApiResponser;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * metodo para restringir el acceso a usuarios no administradores
     */
    protected function allowedAdminAction(){
        if(Gate::denies('admin-action')){
            throw new AuthorizationException('Accion no permitida');
        }
    }
}
