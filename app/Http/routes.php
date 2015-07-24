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
Route::get('top/{page?}', ['as' => 'base','uses'=>'HomeController@index']);
Route::get('recent/{page?}', ['as' => 'base','uses'=>'HomeController@recent']);
Route::get('category/{categoryName}/{page?}', ['uses' => 'HomeController@category']);
Route::post('provider-callback/{provider}', 'Auth\AuthController@handleProviderCallback');
Route::get('provider-login/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('email-validation/{activation_code}', ['as' => 'email-validation','uses' => 'Auth\EmailVerificationController@emailValidation']);
Route::get('resend-validation', ['as' => 'resend-validation','uses' => 'Auth\EmailVerificationController@resendValidationEmail','middleware'=>'auth']);
Route::get('user/{username}', ['uses' => 'UserController@account']);
Route::get('user/get/data', ['uses' => 'UserController@get','middleware' => 'auth']);
Route::post('user/settings/submit', ['uses' => 'UserController@settingsProcess','middleware' => 'auth']);
Route::get('settings', ['uses' => 'UserController@settings','middleware'=>'auth']);
Route::get('post', ['uses' => 'PostController@create']);
Route::post('post/create', ['uses' => 'PostController@create']);
Route::post('post/vote', ['uses' => 'PostController@vote','middleware'=>'auth']);
Route::get('post/gamesearch', ['uses' => 'PostController@gameSearch','middleware'=>'auth']);
Route::get('validate-game', ['uses' => 'PostController@validateGame']);
Route::get('gaf/{gaf_key}', ['uses' => 'PostController@view']);
Route::post('comment/create', ['uses' => 'CommentController@create','middleware'=>'auth']);
Route::get('comment/view/{post_id}/{page}/{comment_id}', ['uses' => 'CommentController@view']);
Route::post('comment/vote', ['uses' => 'CommentController@vote','middleware'=>'auth']);
Route::get('comment/replies/{commentId}/{page}/{limit}/{offset}', ['uses' => 'CommentController@replies']);
Route::get('game/{gameName}', ['uses' => 'PostController@game'])->where('gameName', '[A-Za-z0-9\W]+');
Route::post('feedback', ['uses' => 'FeedbackController@create']);


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
