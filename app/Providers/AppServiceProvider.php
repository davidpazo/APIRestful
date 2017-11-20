<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);
       //para enviar email cuando se registra un usuario.
       User::created(function($user){
           retry(3, function() use($user){
               Mail::to($user->email)->send(new UserCreated($user));
           },100);
       });
       //para enviar email cuando se cambie el correo electronico
        User::updated(function($user){
            if($user->isDirty('email')){
                retry(3, function() use($user) {
                    Mail::to($user->email)->send(new UserMailChanged($user));
                },100);
            }
        });

       /**TODO: FUNCION PARA VER SI FECHA ESTA DISPONIBLE O NO.
       Vacation::updated(function($vacation)){
           if($vacation -> quantity ==0 && $vacation -> estaDisponible()){
               $vacation->status = Vacation::FECHA_NO_DISPONIBLE;
    }
       }*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
