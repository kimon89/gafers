<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comment_votes';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['comment_id', 'user_id','vote'];

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
	public function comment()
	{
		return $this->belongsTo('App\Comment');
	}
}
