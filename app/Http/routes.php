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

Route::get('/', ['as' => 'base','uses'=>'HomeController@index']);
Route::post('provider-callback/{provider}', 'Auth\AuthController@handleProviderCallback');
Route::get('provider-login/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('email-validation/{activation_code}', ['as' => 'email-validation','uses' => 'Auth\EmailVerificationController@emailValidation']);
Route::get('resend-validation', ['as' => 'resend-validation','uses' => 'Auth\EmailVerificationController@resendValidationEmail','middleware'=>'auth']);
Route::get('user/{username}', ['uses' => 'UserController@account']);
Route::get('user/get/data', ['uses' => 'UserController@get','middleware' => 'auth']);
Route::post('user/settings/submit', ['uses' => 'UserController@settingsProcess','middleware' => 'auth']);
Route::get('settings', ['uses' => 'UserController@settings','middleware'=>'auth']);
Route::get('post/create', ['uses' => 'PostController@create','middleware'=>'auth']);
Route::post('post/create', ['uses' => 'PostController@createProcess']);
Route::get('post/gamesearch', ['uses' => 'PostController@gameSearch','middleware'=>'auth']);
Route::get('validate-game', ['uses' => 'PostController@validateGame']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
