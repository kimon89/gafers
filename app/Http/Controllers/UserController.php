<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use Request;
use App\Http\Requests\UpdateSettingsRequest;
use App\Services\CategoryService;

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
	 * Show the account page to the user.
	 *
	 * @return Response
	 */
	public function account($username)
	{
		if (!Request::ajax()) {
			$categories = CategoryService::getAllCategories();
			return view('home',['categories' => $categories]);
		}

		$user = false;
		//find the user by username
		$user = User::select(['id','username','default_avatar'])->where('username','=',$username)->first();
		if ($user) {
			//get the users posts
			foreach($user->posts as $k => &$post){
				if ($post->status == 'active') {
					$post->active = true;
				}
				if ((!Auth::check() && $post->status != 'active') || ($post->status != 'active' && (Auth::user()->id != $post->user_id))){
					unset($user->posts[$k]);
				}
			}
		}

		return response()->json(['success' => true,'data' => $user]);
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
