<script id="feedback-form-template" type="text/x-handlebars-template">
<div class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
	  	<h4 class="modal-title" id="gridSystemModalLabel">Feeback</h4>
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
					<form id="feedback-form" class="form-horizontal" role="form" method="POST" action="/feedback/submit">
						<input id="token" type="hidden" name="_token" value="{{ csrf_token }}">
						<div class="form-group">
							<label for="email-input" class="col-md-3 control-label">Email</label>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-12">
										<input id="email-input" type="text" class="form-control" name="email" value="{{ email }}">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="title-input" class="col-md-3 control-label">Content</label>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-12">
										<textarea id="content-input" class="form-control" name="content" value="{{ content }}"></textarea>
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
