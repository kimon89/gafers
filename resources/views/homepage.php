<script id="homepage-template" type="text/x-handlebars-template">
<div class="container-fluid homepage">
	<div class="row">
		<div class="col-md-12">
			 <h1 style="text-align:center;">A place for all your gaming moments</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			 <h4 style="color:darkgrey;text-align:center;">Win? Fail? or just cool? <a data-action="post" href="#">upload</a> your video and share it with the world!</h4>
		</div>
	</div>
	<div class="row content">
		<div class="col-md-7 featured"></div>
		<div class="col-md-5 posts hidden-sm hidden-xs"></div>
	</div>
</div>
</script>

<script id="homepage-featured" type="text/x-handlebars-template">
{{#each featured}}
	<div class="row post">
		<div class="row">
			<div class="col-md-10 post-title">
				<span><a href="/gaf/{{url_key}}">{{title}}</a><span>
			</div>
			<div class="col-md-2">
				<span data-postid="{{id}}" class="glyphicon glyphicon-arrow-up post-vote {{voted}}"></span>
				<span class="post-points">{{points}}<span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{#if ../isMobile}}
				<video {{#if last}} data-last="true" {{/if}} width="100%" loop controls preload poster="https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg">
						<source src="{{webm}}" type="video/webm">
						<source src="{{mp4}}" type="video/mp4">
					</video>
				{{else}}
				<a href="/gaf/{{url_key}}">
					<video {{#if last}} data-last="true" {{/if}} width="100%" preload loop>
						<source src="{{webm}}" type="video/webm">
						<source src="{{mp4}}" type="video/mp4">
					</video>
				</a>
				{{/if}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 uploader">
				in <a href="/game/{{game.url_name}}">{{game.name}}</a> by {{#if user.username}}<a href="/user/{{user.username}}">{{user.username}}</a>{{else}}anonymous{{/if}}
			</div>
			<div class="col-md-3 post-social">
				<a class="btn btn-social-icon btn-xs btn-facebook" data-ignore="true" href="https://www.facebook.com/sharer/sharer.php?u={{postLocation}}" target="_blank"><i class="fa fa-facebook"></i></a>
				<a class="btn btn-social-icon btn-xs btn-reddit" data-ignore="true" href="//www.reddit.com/submit" onclick="window.location = '//www.reddit.com/submit?url=' + encodeURIComponent('{{postLocation}}'); return false" target="_blank"><i class="fa fa-reddit"></i></a>
				<a href="/gaf/{{url_key}}"<span class="glyphicon glyphicon-comment"></span><span class="comment-count">{{#if comments_count.aggregate}} {{comments_count.aggregate}} {{else}} 0 {{/if}}</span></a>
			</div>
		</div>
	</div>
{{/each}}
<!--<div class="loader"></div>-->
</script>

<script id="homepage-posts" type="text/x-handlebars-template">
{{#each posts}}
<div class="col-md-12 col-xs-12 post-thumb post-{{status}}">
	<span class="title">{{title}}</span>
	<a href="/gaf/{{url_key}}">
		<img width="100%" src="https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg" class="thumb">
	</a>
</div>
{{/each}}
</script>