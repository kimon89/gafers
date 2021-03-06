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
					<form id="post-form" user-id="{{Auth::user()->id}}" class="form-horizontal" role="form" method="POST" action="{{ url('/post/create') }}">
						<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Title</label>
							<div class="col-md-6">
								<input id="title-input" type="text" class="form-control" name="title" value="{{ old('title') }}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">File</label>
							<div class="col-lg-6">
							    <div class="input-group">
							      <span class="input-group-addon">
                                      <label for="file-type-text">URL</label>
							        <input id="file-type-text" type="radio" name="file-type" class="file-type" checked="checked" value="text" aria-label="..." >
							        <label for="file-type-file">Upload</label>
							        <input id="file-type-file" type="radio" name="file-type" class="file-type" value="file" aria-label="...">
							      </span>
							      <input id="file-input" name="file" type="text" class="form-control" aria-label="...">
							    </div><!-- /input-group -->
							</div><!-- /.col-lg-6 -->
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Game</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="game-autocomplete" name="game" value="{{ old('game') }}" >
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
@endsection
