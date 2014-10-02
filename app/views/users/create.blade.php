@extends('layouts.master')

@section('content')
<h2>Add a User</h2>

@include('layouts.partials.messages')

<div class="col-6">
	{{ Form::open(['route' => 'user.store']) }}
		<div class="formfield">
			{{ Form::label('first_name', 'First Name:') }}
			{{ Form::text('first_name', Input::old('first_name'), ['class' => 'required', 'required' => 'required']) }}
		</div>
		<div class="formfield">
			{{ Form::label('last_name', 'Last Name:') }}
			{{ Form::text('last_name', Input::old('last_name'), ['class' => 'required', 'required' => 'required']) }}
		</div>
		<div class="formfield">
			{{ Form::label('email', 'Email:') }}
			{{ Form::email('email', Input::old('email'), ['class' => 'required', 'required' => 'required']) }}
		</div>
		<div class="formfield">
			{{ Form::label('password', 'Password:') }}
			{{ Form::password('password', ['class' => 'required', 'required' => 'required']) }}
		</div>
		<div class="formfield">
			{{ Form::label('password_confirmation', 'Confirm Password:') }}
			{{ Form::password('password_confirmation', ['class' => 'required', 'required' => 'required']) }}
		</div>
</div>
<div class="col-6 last">
		<div class="formfield">
			{{ Form::label('unit_id', 'Link to Unit:') }}
			{{ Form::select('unit_id', $units, Input::old('unit_id'), ['class' => 'required']) }}
		</div>
		<div class="formfield">
			{{ Form::label('role_id', 'User role:') }} <a href="#" class="modal-open" data-modal="roles-modal"><i class="fa fa-info-circle fa-lg"></i></a>
			{{ Form::select('role_id', $roles, Input::old('role_id'), ['class' => 'required']) }}
		</div>
		<div class="formfield">
			{{ Form::checkbox('send_email', 'send_email', Input::old('send_email')) }} Send email notification?
		</div>
</div>

<div class="col-12">
	{{ Form::submit('Add', ['class' => 'primary']) }}
	{{ Form::close() }}
</div>

<div class="modal roles-modal">
	<h2>User Roles</h2>
  <p>Users are assigned a role that dictates how they operate within the online Fipra Lead Office List system. Each role comes with a different set of permissions.</p>
  <p>Administrators can: <em>{{ $admin_perms_list }}</em></p>
  <p>Editors can: <em>{{ $editor_perms_list }}</em></p>
  <p>Viewers can: <em>{{ $viewer_perms_list }}</em></p>
</div>
@stop