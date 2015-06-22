<script id="post-form-template" type="text/x-handlebars-template">
<div class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
	  	<h4 class="modal-title" id="gridSystemModalLabel">Submit something cool</h4>
	</div>
	<div class="modal-body">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
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
					<form id="post-form" class="form-horizontal" role="form" method="POST" action="/post/submit">
						<input id="token" type="hidden" name="_token" value="{{ csrf_token }}">

						<div class="form-group">
							<label for="title-input" class="col-md-4 control-label">Title</label>
							<div class="col-md-6">
								<input id="title-input" type="text" class="form-control" name="title" value="{{ title }}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">File</label>
							<div class="col-lg-6">
							    <div class="input-group">
							      <span class="input-group-addon">
                                      <label for="file-type-text">URL</label>
							        <input id="file-type-text" type="radio" name="file-type" class="file-type" {{file_type_text}} value="text" aria-label="..." >
							        <label for="file-type-file">Upload</label>
							        <input id="file-type-file" type="radio" name="file-type" class="file-type" {{file_type_file}} value="file" aria-label="...">
							      </span>
							      <input id="file-input" name="file" type="{{file_type}}" class="form-control" value="{{file}}" aria-label="...">
							    </div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Game</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="game-autocomplete" name="game" value="{{game}}" >
								<input type="text" id="game-input" name="game-input">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-6">
								<span id="game-holder"></span>
							</div>
						</div>
			       		<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" >
									Create
								</button>
							</div>
						</div>
						
					</form>
					<div class="overlay"></div>
					<div class="progress">
						<div class="progress-bar progress-bar-success progress-bar-striped progress-bar-upload" style="width: 0%">
						</div>
						<div class="progress-bar progress-bar-warning progress-bar-striped progress-bar-convert" style="width: 0%">
						</div>
					</div>
		</div>
		</div>
		</div>
		</div>
		</div>
	</div>
</div>
</script>
