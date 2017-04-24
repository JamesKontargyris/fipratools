@extends('layouts.master')

@section('page-header')
Add a User
@stop

@section('page-nav')
<li><a href="{{ route('users.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6">
		{{ Form::open(['route' => 'users.store']) }}
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
				{{ Form::select('unit_id', $units, Input::old('unit_id'), ['class' => 'select2', 'style' => 'width:100%;']) }}
			</div>
			<div class="formfield">
				{{ Form::label('role_id', 'User role:') }} <a href="#" class="modal-open" data-modal="roles-modal"><i class="fa fa-info-circle fa-lg"></i></a>
				{{ Form::select('role_id', $roles, Input::old('role_id'), ['class' => 'select2', 'style' => 'width:100%;']) }}
			</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Add', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>

<div class="modal roles-modal">
	<h3>User Roles</h3>
  <p>Users are assigned a role that dictates how they operate within the online Fipra Lead Office List system. Each role comes with a different set of permissions.</p>
  <p>Administrators can: <em>{{ $admin_perms_list }}</em></p>
  <p>Heads of Unit can: <em>{{ $head_perms_list }}</em></p>
  <p>Fipriots can: <em>{{ $fipriot_perms_list }}</em></p>
  <p>Special Advisers can: <em>{{ $spad_perms_list }}</em></p>
  <p>Correspondents can: <em>{{ $corr_perms_list }}</em></p>
</div>
@stop