<style>
.nav li:nth-of-type(5) {
  margin-left: 60px;
}

</style>
<script id="navigation-bar" type="text/x-handlebars-template">
<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">
					<div>GAFERS</div>	<img src="/css/icons/logo-tv-trans.png" width=32>
				</a>
				</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
					<li class="top"><a href="/top">Top</a></li>
					<li class="recent"><a href="/recent">Recent</a></li>
					<li class="category-win"><a href="/category/win">Wins</a></li>
					<li class="category-fail"><a href="/category/fail">Fails</a></li>
					<li class="game game-dota-2"><a href="/game/DotA%202">DoTA 2</a></li>
					<li class="game game-league-of-legends"><a href="/game/League%20of%20Legends">LoL</a></li>
					<li class="game game-grand-theft-auto-v"><a href="/game/Grand%20Theft%20Auto%20V">GTA5</a></li>
					<li>
					<form class="navbar-form navbar-left" role="search">
				        <div class="form-group">
				          <input type="text" class="form-control" placeholder="Search for a game">
				        </div>
				    </form>
				    </li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					{{#if username}}
					<li class="dropdown">
							<a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{username}} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/user/{{username}}">My Account</a></li>
								<li><a href="/settings">Settings</a></li>
								<li><a data-action="logout" href="#">Logout</a></li>
							</ul>
						</li>
					{{else}}
						<li><a data-action="login" href="#">Sign In</a></li>
					{{/if}}
						<li class="post-button">
							<a data-action="post" href="#">Post</a>
							<div class="upload-progress hidden"><div></div></div>
						</li>
				</ul>
			</div>
		</div>
	</nav>
	</script>