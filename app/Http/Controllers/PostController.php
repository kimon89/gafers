<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use App\Game;
use Request;
use Log;
use App\Http\Requests\CreatePostRequest;
use Config;

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
		$data = [];

		$url_key_length = Config::get('app.url_key_length');
		$try_count = 0;
		$url_key = '';

		do {
			$url_key_length = $try_count > 5 ? $url_key_length++ : $url_key_length;
			$try_count++;
			$url_key = bin2hex(openssl_random_pseudo_bytes($url_key_length));
			
		} while(!count(Post::where('url_key','=',$url_key)->get()) === false);

		if (Config::get('app.url_key_length') < $url_key_length) {
			//notify admin
		}
		

		//if there is a gif it means that its has already been converted
		if (isset($input['gif'])) {
			$data = [
				'title' => $input['title'],
				'game_id' => $input['game_id'],
				'track_key'	=> $input['track_key'],
				'status'	=> 'active',
				'gif'	=> $input['gif'],
				'mp4'	=> $input['mp4'],
				'webm'	=> $input['webm'],
				'url_key' => $url_key
			];
		} else {
			$data = [
				'title' => $input['title'],
				'game_id' => $input['game_id'],
				'track_key'	=> $input['track_key'],
				'status'	=> 'uploaded',
				'url_key' => $url_key
			];
		}
		$post = new Post($data);

		//save the post for this user
		Auth::user()->posts()->save($post);

		$response = new \stdClass();
		$response->success = true;
		$response->data = null;

		return response()->json($response);
	}


	public function validateGame()
	{
		$input = Request::all();
		if (isset($input['game_id'])) {
			try {
				Game::findOrFail($input['game_id']);
			} catch (\Exception $e) {
				return json_encode(array('success' => false));
			}
		} else {
			return json_encode(array('success' => false));
		}
		return json_encode(array('success' => true));
	}
}
