<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialize;
use Request;
use App\User;
use Auth;
use Session;

class AuthController extends Controller {


	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;


	protected $redirectPath = "/";

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}
    
    /**
     * 
     * @param type $provider
     * @return type
     */
    public function redirectToProvider($provider)
    {
        return Socialize::with($provider)->redirect();
    }

    /**
     * Provider callback
     * @param type $provider
     */
    public function handleProviderCallback($provider)
    {
        //get user data from the provider
        $user_from_facebook = Socialize::with($provider)->user();


        //TODO: should get abstracted somehow for more providers
        if ($provider == 'facebook') {
	        //check to see if this user already exists using the facebook id
	       	$users = User::where('facebook_id','=',$user_from_facebook->id);
	       	$users = $users->count() ? $users : User::where('email','=',$user_from_facebook->email);
	       	
	       	if ($users->count() == 0) {
	       		$username = (is_null($user_from_facebook->nickname) ? $user_from_facebook->user['first_name'] : $user_from_facebook->nickname) . '_' . uniqid();
		        $user = User::create([
					'username' => $username,
					'email' => $user_from_facebook->email,
					'password' => bcrypt(md5($username.'X'.rand())),
					'activation_code' => '',
					'active'	=> 1,
					'facebook_id'	=> $user_from_facebook->id
				]);
	       	} else {
	       		//a user with the same email address already exists link them with facebook
	       		$user = null;
	       		$users_collection = $users->get();
	       		foreach ($users_collection as $user_db) {
	       			if (empty($user_db->facebook_id)) {
			       		$user_db->facebook_id = $user_from_facebook->id;
			       		$user_db->save();
		       		} 
		       		$user = $user_db;
	       		}
	       	}
	       	//if all is good login the user and redirect him 
	       	if ($user) {
	        	Auth::login($user);
	       		return redirect()->back();
	       	} else {
	       		echo 'something went wrong';
	       	}
		} else {
			echo 'not supported yet';
		}
    }

}
