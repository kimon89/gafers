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
use Redirect;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Mail;

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


	public function postRegister(RegisterRequest $request)
	{
		$input = Request::all();
		$activation_code = User::generateActivationCode($input['email']);
		$user = User::create([
			'username' => $input['username'],
			'email' => $input['email'],
			'password' => bcrypt($input['password']),
			'activation_code' => $activation_code,
			'active' => 0,
			'default_avatar' => rand(1,4),
		]);

		$response = new \stdClass();
		if ($user) {
			Auth::login($user);

			Mail::queueOn('email_validations','emails.account_activation', array('activation_code'=>$activation_code), function($message) use($input)
			{
				$message->from('no-reply@gafers.com','Gafers');
			    $message->to($input['email'], $input['username'])->subject('Welcome!');
			});

			$response->success = true;
			$response->data = $user;
		} else {
			$response->success = false;
			$response->data = null;
		}
		
		return response()->json($response);
	}

	public function postLogin(LoginRequest $request)
	{
		$input = Request::all();
		$response = [];
		if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])){
			$response['success'] = true;
			$response['data'] = Auth::user();
            return response()->json($response);
        } else {
        	$response['email'] = 'Sorry, the member name and password you entered do not match. Please try again.';
        	return response(json_encode($response), 401);
        }
	}

	public function getLogout()
	{
		$response = [];
		Auth::logout();
		$response['success'] = true;
		return response()->json($response);
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
        $user_from_facebook = Request::all();


        //TODO: should get abstracted somehow for more providers
        if ($provider == 'facebook') {
	        //check to see if this user already exists using the facebook id
	       	$users = User::where('facebook_id','=',$user_from_facebook['id']);
	       	$users = $users->count() ? $users : User::where('email','=',$user_from_facebook['email']);
	       	
	       		
	       	if ($users->count() == 0) {
	       		$username = (!isset($user_from_facebook['nickname']) ? $user_from_facebook['first_name'] : $user_from_facebook['nickname']) . '_' . uniqid();
		        $user = User::create([
					'username' => $username,
					'email' => $user_from_facebook['email'],
					'password' => bcrypt(md5($username.'X'.rand())),
					'activation_code' => User::generateActivationCode($user_from_facebook['email']),
					'active'	=> 0,
					'default_avatar'	=> rand(1,4),
					'facebook_id'	=> $user_from_facebook['id']
				]);
	       	} else {
	       		//a user with the same email address already exists link them with facebook
	       		$user = null;
	       		$users_collection = $users->get();
	       		foreach ($users_collection as $user_db) {
	       			if (empty($user_db->facebook_id)) {
			       		$user_db->facebook_id = $user_from_facebook['id'];
			       		$user_db->save();
		       		} 
		       		$user = $user_db;
	       		}
	       	}
	       	//if all is good login the user and redirect him 
	       	if ($user) {
	        	Auth::login($user);
	        	$response = [
	        		'success' => true,
	        		'data'	=> $user
	        	];
	        	return response()->json($response);
	       		//return Redirect::intended('/');
	       	} else {
	       		echo 'something went wrong';
	       	}
		} else {
			echo 'not supported yet';
		}
    }

}
