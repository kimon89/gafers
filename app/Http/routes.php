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
Route::get('provider-callback/{provider}', 'Auth\AuthController@handleProviderCallback');
Route::get('provider-login/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('email-validation/{activation_code}', ['as' => 'email-validation','uses' => 'Auth\EmailVerificationController@emailValidation']);
Route::get('resend-validation', ['as' => 'resend-validation','uses' => 'Auth\EmailVerificationController@resendValidationEmail','middleware'=>'auth']);


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
