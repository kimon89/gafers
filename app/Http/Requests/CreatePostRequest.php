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
	        'gif'	=> 'required|regex:@http:\/\/[a-zA-Z]+\.gfycat\.com\/[a-zA-Z0-9]+\.(?:gif)@',
	        'mp4'	=> 'required|regex:@http:\/\/[a-zA-Z]+\.gfycat\.com\/[a-zA-Z0-9]+\.(?:mp4)@',
	        'webm'	=> 'required|regex:@http:\/\/[a-zA-Z]+\.gfycat\.com\/[a-zA-Z0-9]+\.(?:webm)@'
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

   

}
