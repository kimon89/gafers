<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class PostVote extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'post_votes';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['post_id', 'user_id','vote'];

	/**
	 * Define relationship with comments
	 * @return [type] [description]
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * Define relationship with comments
	 * @return [type] [description]
	 */
	public function post()
	{
		return $this->belongsTo('App\Post');
	}
}
