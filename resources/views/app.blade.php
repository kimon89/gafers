<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gafers</title>


	@if (isset($post))
	<meta property="og:title" content="{{$post->title}}" />
	<meta property="og:site_name" content="Best gaming moments"/>
	<meta property="og:url" content="https://dev.gafers.com/gaf/{{$post->url_key}}" />
	<meta property="og:description" content="A place for all your gaming moments" />
	<meta property="fb:app_id" content="651453621654315" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="https://thumbs.gfycat.com/{{$post->file_name}}-thumb360.jpg" />

	@endif

	<link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ secure_asset('/css/bootstrap-social.css') }}">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		//ugly fix
		if (window.location.hash == '#_=_'){
		    // Check if the browser supports history.replaceState.
		    if (history.replaceState) {
		        // Keep the exact URL up to the hash.
		        var cleanHref = window.location.href.split('#')[0];
		        // Replace the URL in the address bar without messing with the back button.
		        history.replaceState(null, null, cleanHref);
		    } else {
		        // Well, you're on an old browser, we can get rid of the _=_ but not the #.
		        window.location.hash = '';
		    }
		}
</script>
</head>
<body>
<div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=<?=config('app.facebook_app_id')?>";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
        </script>
        <script>
        var csrf_token = '{{csrf_token()}}';
        var user_data = <?=(Auth::guest() ? 'null' : Auth::user())?>;
        </script>

	<div class="container main">
		@if ( !Auth::guest() && !Auth::user()->active )
			<div class="alert alert-warning">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Hello, Please verify your email address. If you haven't recieved a verification email we can <a href="/resend-validation">resend</a>  it to you.
	    	</div>
		@endif
		
		@include('flash::message')
		
		@yield('content')
	</div>
	<a data-action="feedback" class="btn btn-default feedback">Feedback</a>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ secure_asset('/js/jquery.autocomplete.js') }}"></script>
	<script src="{{ secure_asset('/js/handlebars.js') }}"></script>
	<script src="{{ secure_asset('/js/main.js') }}"></script>
	</body>
</html>
