<?php namespace App\Http\Controllers;

use \Auth as Auth;
use App\Post;
use Request;
use App\Services\PostService;
use App\Services\CategoryService;

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
	public function index($page = 1)
	{
		if(!Request::ajax()){
			$categories = CategoryService::getAllCategories();
			return view('home',['categories'=>$categories]);
		}
		$posts = PostService::getHomepagePosts($page);
		return response()->json(['success' => true,'data' => $posts]);
	}

	public function recent($page = 1)
	{
		if(!Request::ajax()){
			$categories = CategoryService::getAllCategories();
			return view('home',['categories'=>$categories]);
		}
		$posts = PostService::getRecentPosts($page);
		return response()->json(['success' => true,'data' => $posts]);
	}

	public function category($categoryName, $page = 1)
	{
		if(!Request::ajax()){
			$categories = CategoryService::getAllCategories();
			return view('home',['categories'=>$categories]);
		}
		$posts = PostService::getCategoryPosts($categoryName,$page);
		return response()->json(['success' => true,'data' => $posts]);
	}
}
