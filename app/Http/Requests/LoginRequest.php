<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Auth;

class LoginRequest extends Request {

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
	        'email' => 'required|email',
	     	'password' => 'required'   
	     ];
	}

}
