<script id="list-template" type="text/x-handlebars-template">
	<div class="container-fluid">
		<div class="row posts">
		</div>
	</div>
</script>

<script id="posts-template" type="text/x-handlebars-template">
{{#each posts}}
<div class="col-md-4 col-xs-4 post-thumb post-{{status}}">
	<span class="title">{{title}}</span>
	<a href="/gaf/{{url_key}}">
		<img width="100%" src="https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg" class="thumb">
	</a>
</div>
{{/each}}
</script>