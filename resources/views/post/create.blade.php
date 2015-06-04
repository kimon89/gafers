@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Submit something cool</div>

				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/post/create') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Title</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="title" value="{{ old('title') }}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">File</label>
							<div class="col-lg-6">
							    <div class="input-group">
							      <span class="input-group-addon">
							      	URL
							        <input type="radio" name="file_type" value="url" aria-label="..." >
							        Upload
							        <input type="radio" name="file_type" value="upload" aria-label="...">
							      </span>
							      <input type="text" class="form-control" aria-label="...">
							    </div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Game</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="game-autocomplete" name="game" value="{{ old('game') }}" >
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
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
