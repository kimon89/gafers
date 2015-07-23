<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Auth;

class RegisterRequest extends Request {

	/**
	 * Only active users can create posts
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//return User::where('id', Auth::user()->id)->where('active', 1)->exists();
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		 return [
		 	'username'	=> 'required|between:4,60|unique:users',
	        'email' => 'required|email|unique:users',
	     	'password' => 'required|min:5'
	     ];
	}

}

