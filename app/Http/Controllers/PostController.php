<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use App\Game;
use Request;
use Log;
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
		$input = Request::all();

		$post = new Post([
			'title' => $input['title'],
			'game_id' => $input['game_id'],
			'gif'	=> $input['gif'],
			'mp4'	=> $input['mp4'],
			'webm'	=> $input['webm']
		]);

		//save the post for this user
		Auth::user()->post()->save($post);

		return json_encode(array('success' => true));
	}

	/**
	 * Lookup for games for the autocomple form
	 * @return [type] [description]
	 */
	public function gameSearch()
	{
		return '{
		    "suggestions": [
		        { "value": "United Arab Emirates", "data": "AE" },
		        { "value": "United Kingdom",       "data": "UK" },
		        { "value": "United States",        "data": "US" }
		    ]
		}';
	}

}
