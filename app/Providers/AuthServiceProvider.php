<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\Policies\VacationPolicy;
use App\Policies\WorkerPolicy;
use App\User;
use App\Vacation;
use App\Worker;
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
        Worker::class => WorkerPolicy::class,
        User::class => UserPolicy::class,
        Vacation::class => VacationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //metodo para limitar el resto de acciones que no se han tratado para que lo haga solo el admin
        //Utilizamos un gate.
        Gate::define('admin-action',function($user){
            return $user->esAdmin();
        });

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
