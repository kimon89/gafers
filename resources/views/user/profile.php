<script id="profile-template" type="text/x-handlebars-template">

	<div class="container">
	<h1>{{username}}</h1>
	<span>Member since: </span>
	<h2>Gafs</h2>
	<div class="container-fluid">
	  	<div class="row" style="margin-bottom:20px">
	  		{{#each posts}}
			<div class="col-md-3 .col-md-offset-4 thumb-holder">
				<div style="background-image: url('https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg')" class="thumb"><a href="/gaf/{{id}}"></a></div>
			</div>
			{{/each}}
		</div>
	</div>
	</div>
</script>