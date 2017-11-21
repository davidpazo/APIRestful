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
Route::resource('departments','Departments\DepartmentController',['except'=>['create','edit']]);
/**
 * Worker
 */
Route::resource('workers','Worker\WorkersController',['only'=>['index','show']]);
/**
 * Vacations
 */
Route::resource('vacation','Vacation\VacationController',['only'=>['index','show']]);
/**
 * Users
 */
Route::resource('users','User\UserController',['except'=>['create','edit']]);
Route::name('verify')-> get('users/verify{token}','User/Usercontroller@verify');
Route::name('resend')-> get('users/{user}/resend','User/Usercontroller@resend');

Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
