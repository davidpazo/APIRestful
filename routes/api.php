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
* Department
 */
Route::resource('departments','Department\DepartmentController',['except'=>['create','edit']]);
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
Route::resource('users','User\UserController',['except'=>['create','edit']]);
Route::name('verify')-> get('users/verify{token}','User/Usercontroller@verify');
Route::name('resend')-> get('users/{user}/resend','User/Usercontroller@resend');


