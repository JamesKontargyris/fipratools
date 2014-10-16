@extends('layouts.login')

@section('content')
<div class="row">
	<div class="col-12">
		<h3>Login</h3>
	</div>
</div>
@include ('layouts.partials.messages')

<div class="row">
	<div class="col-6">
		{{ Form::open(['url' => 'login', 'method' => 'POST']) }}
			<div class="formfield">
				{{ Form::label('email', 'Email Address:') }}
				{{ Form::text('email', Input::old('email')) }}
			</div>
			<div class="formfield">
				{{ Form::label('password', 'Password:') }}
				{{ Form::password('password') }}
			</div>
			<div class="formfield">
				{{ Form::submit('Login', ['class' => 'primary']) }}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop