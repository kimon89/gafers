<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Post extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id','title','gif','mp4','webm','game_id','status','track_key','file_name','url_key','category_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Define post user relationship
	 * @return [type] [description]
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * Define post game relationship
	 * @return [type] [description]
	 */
	public function game()
	{
		return $this->belongsTo('App\Game');
	}

	/**
	 * Define post comment relationship
	 * @return [type] [description]
	 */
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

	/**
	 * Define post category relationship
	 * @return [type] [description]
	 */
	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	public function commentsCount()
	{
	  return $this->hasOne('App\Comment')->selectRaw('post_id, count(*) as aggregate')->groupBy('post_id');
	}

}
