<?php namespace App\Services;

use App\User;
use App\Game;
use Auth;
use DB;


class GameService {


	/**
	 * [getPostComments description]
	 * @param  [type]  $postId [description]
	 * @param  integer $page   [description]
	 * @param  integer $limit  [description]
	 * @return [type]          [description]
	 */
	static function getGameByName($gameName)
	{
		return Game::where('name','=',$gameName)->firstOrFail();
	}

}
