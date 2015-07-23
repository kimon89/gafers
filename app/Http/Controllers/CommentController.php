<?php namespace App\Http\Controllers;

use \Auth as Auth;
use Exception;
use App\User;
use App\Comment;
use App\CommentVote;
use Request;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\VoteCommentRequest;
use App\Services\CommentService;

class CommentController extends Controller {


	/**
	 * Create a new comment
	 * @param  CreateCommentRequest $request [description]
	 * @return [type]                        [description]
	 */
	public function create(CreateCommentRequest $request)
	{
		//request has been filtered 
		$input = $request->all();
		$comment = new Comment($input);

		//author of the comment is the currently logged in user
		$comment->user_id = Auth::user()->id;
		$comment->points = 0;

		if ($comment->reply_id) {
			//its a reply to another comment
			try {
				$parentComment = Comment::findOrFail($comment->reply_id);
			} catch (\Exception $e) {
				return response()->json(['success' => false,'data' => []]);
			}
			$comment->post_id = $parentComment->post_id;
		}

		$comment->save();

		//get user data and return to client
		$comment->user;

		return response()->json(['success' => true,'data' => $comment]);
	}

	/**
	 * View comments of a spesific post
	 * @param  int $post_id    [description]
	 * @param  int $comment_id [description]
	 * @return [type]             [description]
	 */
	public function view($postId, $page = 1, $commentId = 0)
	{
		if (!Request::ajax()) {
			return view('home');
		}

		//get all the comments for that post
		$comments = CommentService::getPostComments($postId,$page,5,Auth::check()?Auth::user()->id:false);
		return response()->json(['success' => true,'data' => $comments]);
	}

	public function replies($commentId,$page = 1,$limit = 40, $offset = 0)
	{
		if (!Request::ajax()) {
			return view('home');
		}
		
		//get all the replies for that comment
		$comments = CommentService::getCommentReplies($commentId,$page,$limit,$offset);
		return response()->json(['success' => true,'data' => $comments]);

	}

	/**
	 * Submit a vote for a comment
	 * @param  VoteCommentRequest $request [description]
	 * @return [type]                      [description]
	 */
	public function vote(VoteCommentRequest $request)
	{
		if (!Request::ajax()) {
			return view('home');
		}

		//input has been filtered
		$input = $request->all();

		$comment = Comment::find($input['commentId']);

		//check if the user has voted for this comment before
		//and remove the vote if he has
		$deleted = CommentVote::where('comment_id','=',$input['commentId'])->where('user_id','=',Auth::user()->id)->delete();
		if ($deleted){
			$comment->points = max(0,$comment->points-1);
		} else {
			$comment->points = $comment->points+1;

			//register who voted and for what
			$commentVote = new CommentVote();
			$commentVote->user_id = Auth::user()->id;
			$commentVote->comment_id = $input['commentId'];
			$commentVote->save();
		}
		
		$comment->save();

		return response()->json(['success' => true,'data' => []]);
	}
}
