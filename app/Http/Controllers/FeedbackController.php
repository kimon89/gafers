<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\Feedback;
use Request;
use Log;
use App\Http\Requests\SubmitFeedbackRequest;
use Config;
use Cache;

class FeedbackController extends Controller {

	public function create(SubmitFeedbackRequest $request)
	{		
		$input = Request::all();
		$feedback = new Feedback($input);
		$feedback->save();
		return response()->json(['success' => true,'data' => []]);
	}
}
