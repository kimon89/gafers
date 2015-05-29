<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use App\Commands\SendEmail;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'username' => 'required|max:255|unique:users',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$activation_code = User::generateActivationCode($data['email']);
		$user = User::create([
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'activation_code' => $activation_code
		]);

		//send message to the queue for email validation
		// $res = \Queue::push(new SendEmail('data'),'data','email_validations');
		// \Log::info(var_export($res,true));
		// 
			
		\Mail::queueOn('email_validations','emails.account_activation', array('a'=>1), function($message) use($data)
		{
			$message->from('no-reply@gafers.com','Gafers');
		    $message->to($data['email'], $data['username'])->subject('Welcome!');
		});


		return $user;
	}

}
