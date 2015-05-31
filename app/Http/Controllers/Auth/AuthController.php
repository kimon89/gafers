<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialize;
use Request;

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


	protected $redirectTo = "/";

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
        $user = Socialize::with($provider)->user();
        //now register the user if not registered already
      
    }

}
