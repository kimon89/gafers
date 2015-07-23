<?php namespace App\Services;

use App\Category;
use Auth;
use DB;


class CategoryService {


	/**
	 * [getPostComments description]
	 * @param  [type]  $postId [description]
	 * @param  integer $page   [description]
	 * @param  integer $limit  [description]
	 * @return [type]          [description]
	 */
	static function getCategoryByName($categoryName)
	{
		return Category::where('name','=',$categoryName)->firstOrFail();
	}

	/**
	 * [getPostComments description]
	 * @param  [type]  $postId [description]
	 * @param  integer $page   [description]
	 * @param  integer $limit  [description]
	 * @return [type]          [description]
	 */
	static function getAllCategories()
	{
		return Category::all();
	}

}
