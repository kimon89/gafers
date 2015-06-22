<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use Request;
use App\Http\Requests\UpdateSettingsRequest;

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
			//find the user by username
			$user = User::select(['id','username'])->where('username','=',$username)->first();
			if ($user) {
				//get the users posts
				$user->posts;
			}
		} else {
			$user = Auth::user();
		}

		//if its ajax return json
		//else return the view
		if (Request::ajax()) {
			$response = new \stdClass();
			if ($user) {
				$response->success = true;
			} else {
				$response->success = false;
			}
			$response->data = $user;
			return response()->json($response);
		} else {
			return view('user/account',['user' => $user]);
		}
	}

	/**
	 * Show the settings page to the user.
	 *
	 * @return Response
	 */
	public function settingsProcess(UpdateSettingsRequest $request)
	{
		Auth::user()->username = $request->all()['username']; 
		Auth::user()->save();
		return response()->json(['success' => true,'data' => Auth::user()]);
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

	/**
	 * Returns data of the currently logges in user
	 * @return json
	 */
	public function get()
	{
		$response = new \stdClass();
		$response->success = true;
		//get logged in user
		$response->data = Auth::user();
		return response()->json($response);
	}

}
