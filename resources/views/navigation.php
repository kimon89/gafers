<script id="navigation-bar" type="text/x-handlebars-template">
<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Gafers</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<ul class="nav navbar-nav navbar-right">
					{{#if username}}
					<li class="dropdown">
							<a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{username}} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/user/{{username}}">My Account</a></li>
								<li><a href="/settings">Settings</a></li>
								<li><a href="/logout">Logout</a></li>
							</ul>
						</li>
						<li>
							<a class="btn btn-info create-button" href="/post">Post</a>
						</li>
					{{else}}
						<li><a href="/login">Login</a></li>
						<li><a href="/register">Register</a></li>
					{{/if}}
				</ul>
			</div>
		</div>
	</nav>
	</script>