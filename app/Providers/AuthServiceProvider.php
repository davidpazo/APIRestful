<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        //tiempo de expiracion del token
        Passport::tokensExpireIn(Carbon::now()-> addMinutes(30));
        //el cliente tiene 30 dias para recojer su token, si no tiene que autorizarse uno nuevo
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //Scopes que queremos registrar para restringir acciones a traves de un token.
        Passport::tokensCan([
            'register-data' => 'Solicitar vacaciones',
            'manage-account' => 'Informacion usuario',
            'manage-request' => 'Gestionar solicitudes',
            'read-list' => 'Ver listas usuario',
        ]);
    }
}
