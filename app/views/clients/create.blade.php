@extends('layouts.master')

@section('page-header')
Add a Client
@stop

@section('page-nav')
<li><a href="{{ route('clients.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'clients.store']) }}
<div class="row">
	<div class="col-8">
		<div class="formfield">
			{{ Form::label('name', 'Client name:', ['class' => 'required']) }}
			{{ Form::text('name', Input::old('name')) }}
		</div>
		@if($user->hasRole('Administrator'))
			<div class="formfield">
				{{ Form::label('unit_id', 'Link to unit:', ['class' => 'required']) }}
				{{ Form::select('unit_id', $units, Input::old('unit_id'), ['class' => 'unit-selection select2', 'style' => 'width:100%']) }}
			</div>
		@else
			{{ Form::hidden('unit_id', $user->unit()->pluck('id')) }}
			{{ Form::hidden('unit_name', $user->unit()->pluck('name')) }}
		@endif
		{{ Form::hidden('user_id', $user->id) }}

		<div class="formfield show-uk">
			{{ Form::label('pr_client', 'Mainly PR client?', ['class' => 'required']) }}
			{{ Form::select('pr_client', [0 => 'No', 1 => 'Yes'], Input::old('pr_client'), ['disabled' => 'disabled', 'class' => 'pr-client-selection select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('account_director_id', 'The Account Director to speak to:', ['class' => 'required']) }}
			{{ Form::select('account_director_id', $account_directors, Input::old('account_director_id'), ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('sector_id', 'Client sector:', ['class' => 'required']) }}
			{{ Form::select('sector_id', $sectors, Input::old('sector_id'), ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('type_id', 'Client type:', ['class' => 'required']) }}
			{{ Form::select('type_id', $types, Input::old('type_id'), ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('service_id', 'Client service:', ['class' => 'required']) }}
			{{ Form::select('service_id', $services, Input::old('service_id'), ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
	</div>
	<div class="col-4 last">
		<div class="formfield">
			{{ Form::label('status', 'Current status:', ['class' => 'required']) }}
			{{ Form::select('status', ['' => 'Please select...', 0 => 'Dormant', 1 => 'Active' ], Input::has('status') ? Input::old('status') : 1, ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('comments', 'Comments:') }}
			{{ Form::textarea('comments', Input::old('comments')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Add', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>
@stop