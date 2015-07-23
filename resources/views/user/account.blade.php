@extends('app')

@section('content')
@if ($user)
<h1>{{$user->username}}</h1>
<span>Member since: {{date('jS M Y',strtotime($user->created_at))}}</span>
<h2>Gafs</h2>
@else
<h1>User not found.</h1>
@endif
@endsection