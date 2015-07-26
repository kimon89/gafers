<?php namespace App\Services;

use App\User;
use Auth;
use DB;
use App\PostVote;
use App\Post;
use Cache;
use App\Services\GameService;
use App\Services\CategoryService;

class PostService {


	static function getPostByKey($key)
	{
		$cacheKey = 'post:'.$key;
		$cacheTtl = 5;

		if (Cache::has($cacheKey)) {
			$post = Cache::get($cacheKey);
		} else {
			$post = Post::where('url_key','=',$key)->with(['game','category','user'])->first();
			if (empty($post)) {
				return null;
			}
			if ($post->status != 'active') {
				$cacheTtl = 1;
			}
			Cache::put($cacheKey,$post,$cacheTtl);
		}
		
		return $post;
	}

	static function getPostsByGame($gameId,$notIn = [],$limit = 5)
	{
		$cacheKey = 'posts:game'.$gameId.json_encode($notIn);

		if (Cache::has($cacheKey)) {
			$posts = Cache::get($cacheKey);
		} else {
			$posts = Post::where('game_id','=',$gameId)->where('status','=','active')->whereNotIn('id',$notIn)->with(['game','user','category'])->limit($limit)->get();
			Cache::put($cacheKey,$posts,5);
		}

		foreach($posts as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}

		return $posts;
	}

	static function getPostsByGameName($gameName,$notIn = [])
	{
		try {
			$game = GameService::getGameByName($gameName);
		} catch (\Exception $e){
			throw new \Exception('Game not found');
		}
		return self::getPostsByGame($game->id);
	}

	static function getPostsByCategory($categoryId,$notIn = [],$page = 1,$limit = 5)
	{
		$offset = ($limit*$page)-$limit;
		$cacheKey = 'posts:category'.$categoryId.json_encode($notIn).$page.$limit;

		if (Cache::has($cacheKey)) {
			$posts = Cache::get($cacheKey);
		} else {
			$posts = Post::where('category_id','=',$categoryId)->where('status','=','active')->whereNotIn('id',$notIn)->with(['game','category','commentsCount','user'])->limit($limit)->offset($offset)->orderBy('points','desc')->get();
			Cache::put($cacheKey,$posts,5);
		}

		foreach($posts as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}

		return $posts;
	}

	static function getPostsByCategoryName($categoryName,$notIn = [], $page = 1,$limit = 5)
	{
		try {
			$category = CategoryService::getCategoryByName($categoryName);
		} catch (\Exception $e){
			throw new \Exception('Category not found');
		}

		return self::getPostsByCategory($category->id,$notIn,$page,$limit);
	}

	static function getHomepagePosts($page=1,$limit=5)
	{
		$offsetFeatured = ($limit*$page)-$limit;
		$limitPosts = $limit+6;
		$offsetPosts = ($limitPosts*$page)-$limitPosts;
		$data = [
			'featured' 	=> [],
			'posts'		=> []
		];
		$data['featured'] = Post::where('status','=','active')->with(['game','category','commentsCount','user'])->limit($limit)->offset($offsetFeatured)->orderBy('points','desc')->get();
		$data['posts'] = Post::where('status','=','active')->with(['game','category'])->limit($limitPosts)->offset($offsetPosts)->orderBy('id','desc')->get();
		
		foreach($data['featured'] as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}
		foreach($data['posts'] as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}

		return $data;
	}

	static function getRecentPosts($page=1,$limit=5)
	{
		$offsetFeatured = ($limit*$page)-$limit;
		$limitPosts = $limit+6;
		$offsetPosts = ($limitPosts*$page)-$limitPosts;
		$data = [
			'featured' 	=> [],
			'posts'		=> []
		];
		$data['featured'] = Post::where('status','=','active')->with(['game','category','commentsCount','user'])->limit($limit)->offset($offsetFeatured)->orderBy('id','desc')->get();
		$data['posts'] = Post::where('status','=','active')->with(['game','category','user'])->limit($limitPosts)->offset($offsetPosts)->orderBy('points','desc')->get();
		
		foreach($data['featured'] as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}
		foreach($data['posts'] as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}

		return $data;
	}

	static function getCategoryPosts($categoryName,$page=1,$limit=5)
	{
		$offsetFeatured = ($limit*$page)-$limit;
		$limitPosts = $limit+6;
		$offsetPosts = ($limitPosts*$page)-$limitPosts;
		$data = [
			'featured' 	=> [],
			'posts'		=> []
		];
		$data['featured'] = self::getPostsByCategoryName($categoryName,[],$page,$limit);
		$data['posts'] = Post::where('status','=','active')->with(['game','category','user'])->limit($limitPosts)->offset($offsetPosts)->orderBy('id','desc')->get();
		
		foreach($data['featured'] as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}
		foreach($data['posts'] as &$post) {
			if (Auth::check()) {
				$post->voted = self::hasUserVoted($post->id,Auth::user()->id) ? 'voted' : '';
			}
		}

		return $data;
	}

	static function hasUserVoted($postId,$userId)
	{
		$vote = PostVote::where('post_id','=',$postId)->where('user_id','=',$userId)->get();
		return count($vote);
	}
}
