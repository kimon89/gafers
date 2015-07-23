<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['content', 'user_id','post_id','reply_id','reply_user_id','points'];

	/**
	 * Define relationship with posts
	 * @return [type] [description]
	 */
	public function post()
	{
		return $this->belongsTo('App\Post');
	}

	/**
	 * Define relationship with comments
	 * @return [type] [description]
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * Define relationship with replies
	 * @return [type] [description]
	 */
	public function replies()
	{
		return $this->hasMany('App\Comment','reply_id');
	}
}
