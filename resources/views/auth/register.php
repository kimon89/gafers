<script id="register-form-template" type="text/x-handlebars-template">
<div class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
	  	<h4 class="modal-title" id="gridSystemModalLabel">Register</h4>
	</div>
<div class="modal-body">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
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
						<a class="btn btn-block btn-social btn-lg btn-facebook facebook-login" href="/loginFacebook">
					 	<i class="fa fa-facebook"></i> Sign in with Facebook
					 </a>
					 {{#with formData}}
					<form class="form-horizontal" role="form" method="POST" action="/register">
						<input type="hidden" name="_token" value="{{ csrf_token }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Username</label>
							<div class="col-md-6">
								<input type="text" class="form-control" autofocus required name="username" value="{{ username }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" required name="email" value="{{ email }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" required name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
					{{/with}}
					</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</script>