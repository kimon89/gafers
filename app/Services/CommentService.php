<?php namespace App\Services;

use App\User;
use App\Comment;
use App\CommentVote;
use Auth;
use DB;


class CommentService {


	/**
	 * [getPostComments description]
	 * @param  [type]  $postId [description]
	 * @param  integer $page   [description]
	 * @param  integer $limit  [description]
	 * @return [type]          [description]
	 */
	static function getPostComments($postId, $page = 1, $limit = 5,$userId)
	{
		$offset = ($page*$limit) - $limit;

		$userComments = [];
		//check if the current user has commented for this post
		//and append his comments to the rest of the comments
		if ($userId) {
			$userComments = self::getUserComments($userId,$postId);
		}

		$userCommentsIds = [];
		foreach($userComments as $comment) {
			$userCommentsIds[] = $comment['id'];
		}
		
		$comments = Comment::where('post_id','=',$postId)->where('reply_id','=',0)->whereNotIn('id',$userCommentsIds)->with(['user'
		])->orderBy('points','desc')->orderBy('id','asc')->limit($limit)->offset($offset)->get()->toArray();

		$allComments = array_merge($userComments,$comments);

		//check if the current user has voted any of these comments
		if (Auth::check()) {
			//get all comment ids and the run queries to improve performance
			$commentIds = [];
			foreach ($allComments as $comment) {
				$commentIds[] = $comment['id'];
			}
			//we dont want to lazy load all the votes through each comment as it could be thousands
			$votes = CommentVote::whereIn('comment_id',$commentIds)->where('user_id','=',Auth::user()->id)->get()->toArray();
			
			foreach ($allComments as &$comment) {
				foreach ($votes as $vote) {
					if ($vote['comment_id'] == $comment['id']){
						$comment['voted'] = 'voted';
					}
				}
			}
		}

		//get replies
		foreach ($allComments as &$comment) {
			$comment['replies'] = self::getCommentReplies($comment['id'],1,1);
		}

		//are there more commnts to show?
		$more = (self::getCommentCount($postId,$userCommentsIds) - ($offset+$limit)) > 0 ? true : false;


		return ['comments' => $allComments,'more' => $more];
	}

	static function getCommentReplies($commentId, $page = 1,$limit = 1, $offset = 0)
	{
		$replies = Comment::where('reply_id','=',$commentId)->with(['user'])->limit($limit)->offset($offset)->orderBy('points','desc')->orderBy('id','asc')->get()->toArray();

		$replyIds = [];
		//check if the current user has voted any of these comments
		if (Auth::check()) {
			//get all comment ids and the run queries to improve performance
			foreach ($replies as $comment) {
				$replyIds[] = $comment['id'];
			}
			//we dont want to lazy load all the votes through each comment as it could be thousands
			$votes = CommentVote::whereIn('comment_id',$replyIds)->where('user_id','=',Auth::user()->id)->get()->toArray();
			
			foreach ($replies as &$comment) {
				foreach ($votes as $vote) {
					if ($vote['comment_id'] == $comment['id']){
						$comment['voted'] = 'voted';
					}
				}
			}
		}


		$more = (self::getRepliesCount($commentId) - ($offset+1)) > 0 ? true : false;
		return ['replies' => $replies,'more' => $more];
	}

	static function getRepliesCount($commentId)
	{
		return Comment::where('reply_id','=',$commentId)->count();
	}

	static function getCommentCount($postId, $notIn = [])
	{
		return Comment::where('post_id','=',$postId)->where('reply_id','=',0)->whereNotIn('id',$notIn)->count();
	}

	/**
	 * [getUserComments description]
	 * @param  [type]  $userId  [description]
	 * @param  [type]  $postId  [description]
	 * @param  integer $replyId [description]
	 * @return [type]           [description]
	 */
	static function getUserComments($userId, $postId, $replyId = 0, $limit = 10)
	{
		$userComments = Comment::where('post_id','=',$postId)->where('reply_id','=',$replyId)->where('user_id','=',$userId)->with([
			'replies'=>function($query){
				$query->limit(1)->with(['user'])->get();
			}
			,'user'
			])->orderBy('id','desc')->limit($limit)->get()->toArray();

		return $userComments;
	}

}
