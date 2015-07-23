<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Post;
use App\Game;
use App\PostVote;
use Request;
use Log;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\VotePostRequest;
use Config;
use Cache;
use App\Services\PostService;
use App\Services\GameService;
use App\Services\CategoryService;

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
	 * Processes the post data
	 * @return [type] [description]
	 */
	public function create(CreatePostRequest $request)
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
		
		$data = [
			'title' => $input['title'],
			'game_id' => $input['game_id'],
			'track_key'	=> $input['track_key'],
			'status'	=> 'uploaded',
			'url_key' => $url_key,
			'category_id' => $input['category_id']
		];

		//if there is a filename it means that its has already been converted
		if (isset($input['filename'])) {
			$data['status'] = 'converted';
			$data['file_name'] = $input['filename'];
		}

		$post = new Post($data);

		//save the post for this user
		if (Auth::check()) {
			Auth::user()->posts()->save($post);
		} else {
			$post->user_id = 0;
		}

		$post->save();

		return response()->json(['success' => true,'data' => []]);
	}

	/**
	 * Returns data of a spesific post
	 * @return json [description]
	 */
	public function view($gafKey)
	{
		$post = PostService::getPostByKey($gafKey);

		if (!Request::ajax()) {
			$categories = CategoryService::getAllCategories();
			return view('home',['post' => $post,'categories' => $categories]);
		}
		$related = PostService::getPostsByGame($post->game_id,[$post->id],3);
		return response()->json(['success' => true,'data' => ['post'=>$post,'related'=>$related]]);
	}

	public function vote(VotePostRequest $request)
	{
		if (!Request::ajax()) {
			$categories = CategoryService::getAllCategories();
			return view('home',['categories'=>$categories]);
		}

		//input has been filtered
		$input = $request->all();

		$post = Post::find($input['post_id']);

		//check if the user has voted for this comment before
		//and remove the vote if he has
		$deleted = PostVote::where('post_id','=',$input['post_id'])->where('user_id','=',Auth::user()->id)->delete();
		if ($deleted){
			$post->points = max(0,$post->points-1);
		} else {
			$post->points = $post->points+1;

			//register who voted and for what
			$postVote = new PostVote();
			$postVote->user_id = Auth::user()->id;
			$postVote->post_id = $input['post_id'];
			$postVote->save();
		}
		
		$post->save();

		return response()->json(['success' => true,'data' => []]);
	}

	public function game($gameName)
	{
		$gameName = urldecode($gameName);
		if (!Request::ajax()) {
			$categories = CategoryService::getAllCategories();
			return view('home',['categories' => $categories]);
		}

		$posts = PostService::getPostsByGameName($gameName);

		return response()->json(['success' => true,'data' => $posts]);
	}


	/**
	 * [validateGame description]
	 * @return [type] [description]
	 */
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
