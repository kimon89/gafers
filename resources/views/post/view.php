<script id="post-template" type="text/x-handlebars-template">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-7 post">
			<div class="row">
				<div class="col-md-10 post-title full">
					<span>{{post.title}}</span>
				</div>
				<div class="col-md-2 ">
					<span data-postid="{{post.id}}" class="glyphicon glyphicon-arrow-up post-vote {{post.voted}}"></span>
					<span class="post-points">{{post.points}}<span>			
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row video {{post.status}}">
						<div class="col-md-12">
							{{#if post.active}}
								{{#if isMobile}}
								<video width="100%" autoplay controls loop poster="https://thumbs.gfycat.com/{{post.file_name}}-thumb360.jpg">
									<source src="{{post.webm}}" type="video/webm">
									<source src="{{post.mp4}}" type="video/mp4">
								</video>
								{{else}}
								<video width="100%" autoplay loop>
									<source src="{{post.webm}}" type="video/webm">
									<source src="{{post.mp4}}" type="video/mp4">
								</video>
								{{/if}}
							{{else}}
							<img src="/css/icons/{{post.status}}.png" width=200>
							<span>{{post.status}}</span>
							{{/if}}
						</div>
					</div>
					{{#if isMobile}}
					
					{{else}}
					<div class="row controls">
						<div class="col-md-12">
							<div id='seekBar' value='0'>
								<div id='seekBarInner'></div>
							</div>
							<span class="glyphicon glyphicon-pause video-pause"></span>
							<span class="video-time"></span>
							<span class="glyphicon glyphicon-resize-full"></span>
						</div>	
					</div>
					{{/if}}
				</div>
			</div>
			<div class="row">
				<h3>More from {{post.game.name}}</h3>
					{{#each related}}
					<div class="col-md-4 col-xs-4 .col-md-offset-4 post-thumb post-{{this.status}}">
						<span class="title">{{this.title}}</span>
						<a href="/gaf/{{this.url_key}}">
							<img width="100%" src="https://thumbs.gfycat.com/{{this.file_name}}-thumb360.jpg" class="thumb">
						</a>
					</div>
					{{/each}}
			</div>
		</div>
		<div class="col-md-5">
			<div class="row post-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4 post-stats">
							<div class="row">
								<div class="col-md-12">
									<span class="post-views">{{post.views}} views</span>
								</div>
							</div>
							<div class="row uploader">
								<div class="col-md-12">
									by {{#if post.user.username}}<a href="/user/{{post.user.username}}">{{post.user.username}}</a>{{else}}anonymous{{/if}}
								</div>
							</div>
						</div>
						<div class="col-md-8 post-game">
							<span>{{post.game.name}}</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 post-social">
							<a class="btn btn-social-icon btn-xs btn-facebook" data-ignore="true" href="https://www.facebook.com/sharer/sharer.php?u={{postLocation}}" target="_blank"><i class="fa fa-facebook"></i></a>
							<a class="btn btn-social-icon btn-xs btn-reddit" data-ignore="true" href="//www.reddit.com/submit" onclick="window.location = '//www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false" target="_blank"><i class="fa fa-reddit"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</script>
