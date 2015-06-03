<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use Request;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller {

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
	 * Displayes the post creation form
	 * @return [type] [description]
	 */
	public function create()
	{
		return view('/post/create');
	}

	/**
	 * Processes the post data
	 * @return [type] [description]
	 */
	public function createProcess(CreatePostRequest $request)
	{
		var_dump($input = Request::all());
		die();
		$post = new Post(['title' => '']);
		return view('/post/create');
	}

}
