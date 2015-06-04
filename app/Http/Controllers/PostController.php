<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use App\Game;
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
		$input = Request::all();

		$post = new Post(['title' => $input['title']]);

		//save the post for this user
		Auth::user()->post()->save($post);


		//associate games to posts
		$games = [['name' => 'Far Cry 3','id' => 1],['name' => 'GTA 3','id' => null]];
		$games_to_save = [];
		foreach ($games as $k => $game) {
			//check if game exists by id or by name. 
			$game_from_db = empty($game['id']) ? null : ($game_found = Game::find($game['id']) ? $game_found : Game::where('name',$game['name']));

			//if it doesn't exist create it
			if (empty($game_from_db)) {
				$game = new Game(['name' => $game['name']]);
			} else {
				$game = $game_from_db;
			}
			//save to array to mass save them
			$games_to_save[] = $game;
		}

		//associate games to post
		$post->game()->saveMany($games_to_save);


		return view('/post/create');
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
