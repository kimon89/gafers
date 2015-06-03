<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;

class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the account page to the user.
	 *
	 * @return Response
	 */
	public function account($username = null)
	{
		$user = false;
		if (!is_null($username)) {
			$user = User::where('username','=',$username)->first();
		} else {
			$user = Auth::user();
		}
		
		return view('user/account',['user' => $user]);
	}

	/**
	 * Show the settings page to the user.
	 *
	 * @return Response
	 */
	public function settings()
	{
		return view('user/settings');
	}

}
