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
							<label for="title-input" class="col-md-3 control-label">Title</label>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-12">
										<input id="title-input" type="text" class="form-control" placeholder="Think of a good title" name="title" value="{{ title }}" required>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group game">
							<label class="col-md-3 control-label">Game</label>
							<div class="col-md-7">
								<div class="row">
									<div class="col-md-11">
									<input type="text" class="form-control" id="game-autocomplete" placeholder="Start typing a game" name="game" {{#if game}} value="{{game}}" disabled="true"{{/if}} required>
									<input type="text" id="game-input" {{#if gameId}} value="{{gameId}}"{{/if}} name="game-input">
									</div>
									<span class="glyphicon glyphicon-remove-sign {{#if game}} {{else}} hidden{{/if}}" ></span>
								</div>
							</div>
						</div>
						<div class="form-group category">
							<label class="col-md-3 control-label">Type</label>
							<div class="col-md-7">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group" data-toggle="buttons">
											<?php foreach($categories as $k => $category) { ?>
							                <label class="btn btn-default {{#if selectedCategory<?=$category->id?>}}active{{/if}} category-<?=$category->name?>">
							                    <input type="radio" name="category" value="<?=$category->id?>" /> <?=ucfirst($category->name)?>
							                </label> 
							                <?php } ?>
							           	</div>	
						            </div>
					            </div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">File</label>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-5">
									    <div class="btn-group file-type-select" role="group" aria-label="...">
									    	<label type="button" data-type="upload" class="btn btn-default" for="file-input">Upload</label>
										  	<button type="button" data-type="url" class="btn btn-default">URL</button>
										</div>	
									</div>
									<div class="col-md-7 file-type">
										<input id="url-input" name="url" type="text" class="form-control hidden" value="{{url}}">
										<input id="file-input" name="file" type="file" class="form-control hidden">	
									</div>
									<div class="col-md-7 upload-progress hidden">
											<div class="filename"></div>
											<div class="progress">
												<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
											</div>
									</div>
								</div>
								<div  class="row">
									<div class="col-md-12">
										<div>
											<i><small>Max upload size 300mb, max duration 15 seconds</small></i>
										</div>
									</div>
								</div>
							</div>
						</div>
			       		<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary submit" >
									Submit
								</button>
							</div>
						</div>
						
					</form>
		</div>
		</div>
		</div>
		</div>
		</div>
	</div>
</div>
</script>
