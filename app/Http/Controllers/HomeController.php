<?php namespace App\Http\Controllers;

use \Auth as Auth;
use App\Post;
use Request;

class HomeController extends Controller {

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
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::where('status','=','active')->get();
		$featured_post = Post::where('status','=','featured')->get();
		$posts = $featured_post->merge($posts);
		$response = [
			'success' => true,
			'data'	=> $posts
		];
		if (Request::ajax()) {
			return json_encode($response);
		} else {
			return view('home');
		}
	}



}
