<script id="homepage-template" type="text/x-handlebars-template">
<div class="container-fluid">
  <h1 style="text-align:center;">A place for all your gaming moments</h1>

	<div class="row" style="margin-bottom:20px">
		<div class="col-md-6 col-md-offset-3 featured">
		<video width="100%" autoplay loop>
			<source src="{{featured.[0].webm}}" type="video/webm">
			<source src="{{featured.[0].mp4}}" type="video/mp4">
		</video>
		</div>
	</div>
  	<div class="row" style="margin-bottom:20px">
  		{{#each posts}}
		<div class="col-md-3 .col-md-offset-4 thumb-holder">
			<div style="background-image: url('https://thumbs.gfycat.com/{{file_name}}-thumb360.jpg')" class="thumb"><a href="/gaf/{{id}}"></a></div>
		</div>
		{{/each}}
	</div>
</div>
</script>