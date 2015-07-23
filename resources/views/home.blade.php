@extends('app')
@section('content')
<?php 
	
	include '../resources/views/navigation.php';
	include '../resources/views/auth/login.php';
	include '../resources/views/auth/register.php';
	include '../resources/views/user/profile.php';
	include '../resources/views/post/create.php';
	include '../resources/views/homepage.php';
	include '../resources/views/user/settings.php';
	include '../resources/views/post/view.php';
	include '../resources/views/post/list.php';
	include '../resources/views/comment/view.php';
?>
@endsection
