<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password','activation_code','active','facebook_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	
	/**
	 * Generates the activation code that will be used to
	 * verify a users email address. The activation code is an 
	 * md5 of the uniqid method with the email of the user as a prefix
	 * @param  string $email The email of the user
	 * @return string        An md5 hash
	 */
	public static function generateActivationCode($email) 
	{
		return md5(uniqid($email));
	}

	/**
	 * Define relationship with posts
	 * @return [type] [description]
	 */
	public function post()
	{
		return $this->hasMany('App\Post');
	}

	/**
	 * Define relationship with comments
	 * @return [type] [description]
	 */
	public function comment()
	{
		return $this->hasMany('App\Comment');
	}

}
