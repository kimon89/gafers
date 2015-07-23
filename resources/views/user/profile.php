<script id="profile-template" type="text/x-handlebars-template">

	<div class="container user-profile">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-1 user-avatar">
					<img width="50" src="/css/icons/default_avatars/{{default_avatar}}.png">
				</div>
				<div class="col-md-11 user-username">
					<div>{{username}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3>Gafs<h3>
				</div>
			</div>
			{{#if ownProfile}}
			<div class="row">
				<div class="col-md-5">
					<i>(Only active gafs are visible to other users)</i>		
				</div>
			</div>
			{{/if}}
		  	<div class="row user-posts">
		  		{{#each posts}}
				<div class="col-md-3 .col-md-offset-4 post-thumb post-{{status}}">
					<span class="title">{{title}}</span>
					{{#if active}} 
					<a href="/gaf/{{url_key}}">
						<img width="100%" src="https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg" class="thumb">
					</a>
					{{else}}
						<img width="100%" src="/css/icons/error.png" class="thumb">
					{{/if}}
				</div>
				{{/each}}
			</div>
	</div>
	</div>
</script>