<script id="post-template" type="text/x-handlebars-template">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-7">
			{{#with post}}
			<div class="row">
				<div class="col-md-12">
					<h3>{{title}}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row video">
						<div class="col-md-12">
							<video width="100%" autoplay loop>
								<source src="{{webm}}" type="video/webm">
								<source src="{{mp4}}" type="video/mp4">
							</video>
						</div>
					</div>
					<div class="row controls">
						<div class="col-md-12">
							<div id='seekBar' value='0'>
								<div id='seekBarInner'></div>
							</div>
							<span class="glyphicon glyphicon-pause video-pause"></span>
							<span class="video-time"></span>
						</div>	
					</div>
				</div>
			</div>
			{{/with}}
			<div class="row">
				{{#with post}}
				{{#with game}}
				<h3>More from {{name}}</h3>
				{{/with}}
				{{/with}}
				{{#with related}}
					{{#each this}}
					<div class="col-md-4 col-xs-4 .col-md-offset-4 post-thumb post-{{status}}">
						<span class="title">{{title}}</span>
						<a href="/gaf/{{url_key}}">
							<img width="100%" src="https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg" class="thumb">
						</a>
					</div>
					{{/each}}
				{{/with}}
			</div>
		</div>
		<div class="col-md-5">
			<div class="row post-info">
				<div class="col-md-12">
					<div class="row">
						{{#with post}}
						<div class="col-md-4 post-stats">
							<span class="post-points">{{points}}</span><span data-postid="{{id}}" class="glyphicon glyphicon-arrow-up post-vote {{voted}}"></span>
							<span class="post-views">{{views}}<span class="glyphicon glyphicon-eye-open"></span></span>
						</div>
						<div class="col-md-8 post-game">
							<span>{{#with game}} {{name}}{{/with}}</span>
						</div>
						{{/with}}
					</div>
					<div class="row">
						<div class="col-md-6 post-social">
							<a class="btn btn-social-icon btn-s btn-facebook" data-ignore="true" href="https://www.facebook.com/sharer/sharer.php?u={{postLocation}}" target="_blank"><i class="fa fa-facebook"></i></a>
							<a class="btn btn-social-icon btn-s btn-reddit" data-ignore="true" href="//www.reddit.com/submit" onclick="window.location = '//www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false" target="_blank"><i class="fa fa-reddit"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</script>
