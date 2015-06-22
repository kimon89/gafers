<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Auth;

class UpdateSettingsRequest extends Request {

	/**
	 * All users can access their settings
	 * @return bool
	 */
	public function authorize()
	{
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
	        'username' => 'between:4,60|unique:users',
    	];
	}
}
