<script id="settings-template" type="text/x-handlebars-template">
	<div class="container">
	<h1>Settings</h1>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
		{{#if success}}
		<div class="alert alert-success">
			All changes saved
		</div>
		{{/if}}
		{{#if errors}}
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				{{#each errors}}
					<li>{{this}}</li>
					{{/each}}
			</ul>
		</div>
		{{/if}}
		{{#with user}}
	  	<form id="settings-form" class="form-horizontal" role="form" method="POST" action="/user/settings">
			<input id="token" type="hidden" name="_token" value="{{ csrf_token }}">
			<div class="form-group">
				<label for="title-input" class="col-md-2 control-label">Username</label>
				<div class="col-md-4">
					<input id="title-input" type="text" class="form-control" name="username" value="{{username}}" >
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2 col-md-offset-2">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</form>
		{{/with}}
		</div>
		</div>
	</div>
	</div>
</script>