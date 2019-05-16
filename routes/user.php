<?php

/*
|--------------------------------------------------------------------------
| API User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API User routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|
| Rutas del usuario.
|
*/

Route::post('login',  'User\UserController@login');
Route::get('refresh', 'User\UserController@refresh');
Route::post('register',  'User\UserController@register');
Route::post('logout', 'User\UserController@logout');
Route::get('me',      'User\UserController@me'); 

// envio del link
Route::post('sendResetLinkEmail', 'User\ForgotPasswordController@sendResetLinkEmail')->name('sendResetLinkEmail');
// modificamos la contraseña
Route::post('reset', 'User\ResetPasswordController@reset');



// pruebas
Route::post('verifyEmail', 'User\UserController@verifyEmail');
