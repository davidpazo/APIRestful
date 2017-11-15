<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
* Departments
 */
Route::resource('departments','Departments\DepartmentController',['only'=>['index','show']]);
/**
 * Workers
 */
Route::resource('workers','Workers\WorkersController',['only'=>['index','show']]);
/**
 * Vacations
 */
Route::resource('vacation','Vacation\VacationController',['only'=>['index','show']]);
/**
 * Users
 */
Route::resource('users','User\UserController',['only'=>['index','show']]);


