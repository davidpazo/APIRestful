<?php

use App\User;
use App\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //PARA BLOQUEAR LAS FOREIGN KEYS MIENTRAS SE HACE LA IMPORTACION O MIGRATION
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Department::truncate();
        //para que no haga ingresos en el registro log
        User::flushEventListeners();
        Department::flushEventListeners();

        $cantidadUsuarios = 3;
        $cantidadDepartments = 5;
        $cantidadWorkers = 8;

        factory(User::class, $cantidadUsuarios) -> create();
        factory(Department::class,$cantidadDepartments)-> create()-> each(
            function ($producto){
                $departamentos = Department::all()-> random(mt_rand(1,5))->pluck('id');
            }
        );
    }
}
