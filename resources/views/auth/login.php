<style>
.btn-link.register,.btn-link.password{
	float: right;
}
</style>

<script id="login-form-template" type="text/x-handlebars-template">
<div class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
	  	<h4 class="modal-title" id="gridSystemModalLabel">Login</h4>
	</div>
<div class="modal-body">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
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
					 <a class="btn btn-block btn-social btn-lg btn-facebook facebook-login" data-action="loginFacebook" href="#">
					 	<i class="fa fa-facebook"></i> Sign in with Facebook
					 </a>
					<form id="login-form" class="form-horizontal" role="form" method="POST" action="/loginSubmit">
						<input type="hidden" name="_token" value="{{ csrf_token }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" required value="{{ email }}">
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
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Login</button>
								<a class="btn btn-link register" data-action="register" >Register</a>
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