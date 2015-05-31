<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('provider-callback/{provider}', 'Auth\AuthController@handleProviderCallback');
Route::get('provider-login/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('email-validation', ['as' => 'email-validation','uses' => 'HomeController@index']);


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
