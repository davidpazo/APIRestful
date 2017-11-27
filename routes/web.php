<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', function () {
    return view('welcomi');
});
Route::get('index', function () {
    return view('home');
});
Route::get('vacation', function () {
    return view('create');
});
Route::get('login', function () {
    return view('login');
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

//Vacaciones
//Route::get('/vacaciones/workers', 'HomeController@getTokens')->name('personal-tokens');
Route::get('/vacaciones/vacations', 'HomeController@getVacations')->name('vacations');
//Auth::routes();
//Route::get('/tokens/my-tokens', 'HomeController@getTokens')->name('personal-tokens');
//Route::get('/tokens/my-clients', 'HomeController@getClients')->name('personal-clients');
//Route::get('/tokens/authorized-clients', 'HomeController@getAuthorizedClients')->name('authorized-clients');
Route::get('/home', 'HomeController@index')->name('home');
/*Route::get('/', function(){
    return view('home');
})->middleware('guest');*/
