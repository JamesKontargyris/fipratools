@extends('layouts.master')

@section('page-header')
Editing: {{ $edit_user->getFullName() }}
@stop

@section('page-nav')
<li><a href="{{ route('users.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-8">
		{{ Form::open(['method' => 'PUT', 'url' => 'users/' . $edit_user->id]) }}
			<div class="formfield">
				{{ Form::label('first_name', 'First Name:') }}
				{{ Form::text('first_name', isset($edit_user->first_name) ? $edit_user->first_name : '', ['class' => 'required', 'required' => 'required']) }}
			</div>
			<div class="formfield">
				{{ Form::label('last_name', 'Last Name:') }}
				{{ Form::text('last_name', isset($edit_user->last_name) ? $edit_user->last_name : '', ['class' => 'required', 'required' => 'required']) }}
			</div>
			<div class="formfield">
				{{ Form::label('email', 'Email:') }}
				{{ Form::email('email', isset($edit_user->email) ? $edit_user->email : '', ['class' => 'required', 'required' => 'required']) }}
			</div>
			<div class="formfield">
				{{ Form::label('unit_id', 'Link to Unit:') }}
				{{ Form::select('unit_id', $units, isset($edit_user->unit_id) ? $edit_user->unit_id : '', ['class' => 'required']) }}
			</div>
			<div class="formfield">
				{{ Form::label('role_id', 'User role:') }} <a href="#" class="modal-open" data-modal="roles-modal"><i class="fa fa-info-circle fa-lg"></i></a>
				{{ Form::select('role_id', $roles, $edit_user->roles()->pluck('role_id'), ['class' => 'required']) }}
			</div>
	</div>
	<div class="col-4 last">
			<div class="formfield">
				{{ Form::label('password', 'Change Password:') }}
				{{ Form::password('password') }}
			</div>
			<div class="formfield">
				{{ Form::label('password_confirmation', 'Confirm New Password:') }}
				{{ Form::password('password_confirmation') }}
			</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Update', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>

<div class="modal roles-modal">
	<h3>User Roles</h3>
  <p>Users are assigned a role that dictates how they operate within the online Fipra Lead Office List system. Each role comes with a different set of permissions.</p>
  <p>Administrators can: <em>{{ $admin_perms_list }}</em></p>
  <p>Unit Managers can: <em>{{ $manager_perms_list }}</em></p>
  <p>Fipriots can: <em>{{ $fipriot_perms_list }}</em></p>
</div>
@stop