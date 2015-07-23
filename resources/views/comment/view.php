<script id="comments-container" type="text/x-handlebars-template">
<div class="row comments">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<h4>Comments</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea class="form-control comment-area" data-postid="{{postId}}" placeholder="Add your comment" rows="1" name="content"></textarea>
			</div>
		</div>
		<div class="row comments-holder">
			<div class="col-md-12">

			</div>
		</div>
	</div>
</div>
</script>

<script id="comments-template" type="text/x-handlebars-template">
{{#each comments}}
<div data-commentid="{{id}}" class="row comment-row comment-row-level-0">
	<div class="col-md-12 comment">
		<div class="row">
			<div class="col-md-12">
				<div class="comment-content">
					{{content}}
				</div>
			</div>
		</div>
		{{#with user}}
			<a class="comment-author" href="/user/{{username}}"><img width="20" src="/css/icons/default_avatars/{{default_avatar}}.png"><span>{{username}}</span></a>
		{{/with}}
		<div class="points">
			<span>{{points}}</span><span data-commentid="{{id}}" class="glyphicon glyphicon-arrow-up comment-vote {{voted}}"></span>
		</div>
		<div class="row">
			<div class="col-md-12">
				<span class="comment-reply-button" data-commentid="{{id}}">Reply</span>
			</div>
		</div>
	</div>
</div>
{{/each}}
{{#if more}}
	<div class="row more">
		<div class="col-md-12">
			<span data-page="{{page}}" class="btn btn-default more-comments">More</span>
		</div>
	</div>
{{/if}}
</script>

<script id="replies-container-template" type="text/x-handlebars-template">
	<div class="row replies">
		<div class="col-md-12 col-md-offset-1">
			<div class="row">
				<div class="col-md-12">
					{{{repliesHtml}}}
				</div>
			</div>
			{{#if more}}
			<div class="row">
				<div class="col-md-12">
					<span data-page="{{page}}" data-commentid="{{commentId}}" class="btn btn-default more-replies">More</span>
				</div>
			</div>
			{{/if}}
		<div>
	</div>
</script>


<script id="replies-template" type="text/x-handlebars-template">
{{#each replies}}
<div class="row comment-row">
	<div class="col-md-12 comment">
		<div class="row">
			<div class="col-md-12">
				<div class="comment-content">
					{{content}}
				</div>
			</div>
		</div>
		{{#with user}}
			<a class="comment-author" href="/user/{{username}}"><img width="20" src="/css/icons/default_avatars/{{default_avatar}}.png"><span>{{username}}</span></a>
		{{/with}}
		<div class="points">
			<span>{{points}}</span><span data-commentid="{{id}}" class="glyphicon glyphicon-arrow-up comment-vote {{voted}}"></span>
		</div>
		<span class="comment-reply-button" data-commentid="{{../parentId}}">Reply</span>
	</div>
</div>
{{/each}}
</script>

<script id="comments-reply-template" type="text/x-handlebars-template">
	<div class="row">
	<div class="col-md-12">
	<textarea class="form-control comment-area comment-reply" data-commentid="{{commentId}}" placeholder="Add your comment" rows="1" name="content">{{replyTo}}</textarea>
	</div>
	</div>
</script>
