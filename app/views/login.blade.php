@extends('layouts.login')

@section('content')
	@include ('layouts.partials.messages')

	<div class="login-email-form">
		{{ Form::open(['url' => 'login', 'method' => 'POST']) }}
		{{ Form::label('email', 'Your Fipra email address:') }}
		{{ Form::text('email', Input::old('email'), ['placeholder' => 'your.name@fipra.com']) }}
		{{ Form::label('password', 'Password:') }}
		{{ Form::password('password', ['placeholder' => 'Password']) }}
		{{ Form::submit('Login', ['class' => 'secondary']) }} &nbsp;&nbsp;&nbsp;<a href="/password/reset" style="color:white; font-size:12px;">I've forgotten my password</a>
		{{ Form::close() }}
	</div>
@stop