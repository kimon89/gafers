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
	        'title' => 'required|between:5,120',
	        'game_id' => 'required|exists:games,id',
	        'category_id' => 'required|exists:categories,id',
    	];
	}

    public function forbiddenResponse()
    {
        // Optionally, send a custom response on authorize failure 
        // (default is to just redirect to initial page with errors)
        // 
        // Can return a response, a view, a redirect, or whatever else
        //return response('Please verfiry your email', 403);
    }

   

}
