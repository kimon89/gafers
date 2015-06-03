<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Auth;

class CreatePostRequest extends Request {

	/**
	 * Only active users can create posts
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return User::where('id', Auth::user()->id)->where('active', 1)->exists();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		 return [
	        'title' => 'required|max:120',
	        'game' => 'required',
    	];
	}

    public function forbiddenResponse()
    {
        // Optionally, send a custom response on authorize failure 
        // (default is to just redirect to initial page with errors)
        // 
        // Can return a response, a view, a redirect, or whatever else
        flash()->error('Please verify your email first');
       return $this->redirector->back();
    }

    public function response(array $errors)
    {
        // If you want to customize what happens on a failed validation,
        // override this method.
        // See what it does natively here: 
        // https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/Http/FormRequest.php
    }

}
