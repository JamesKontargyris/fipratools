@extends('layouts.master')

@section('page-header')
Add a Client
@stop

@section('page-nav')
<li><a href="{{ route('clients.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
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
				{{ Form::select('unit_id', $units, Input::old('unit_id')) }}
			</div>
		@else
			{{ Form::hidden('unit_id', $user->unit()->pluck('id')) }}
		@endif
		{{ Form::hidden('user_id', $user->id) }}

		<div class="formfield">
			{{ Form::label('account_director_id', 'The Account Director to speak to:', ['class' => 'required']) }}
            {{ Form::select('account_director_id', $account_directors, Input::old('account_director_id')) }}
		</div>
		<div class="formfield">
			{{ Form::label('pr_client', 'Mainly PR client?', ['class' => 'required']) }}
			{{ Form::select('pr_client', [0 => 'No', 1 => 'Yes'], Input::old('pr_client')) }}
		</div>
		<div class="formfield">
			{{ Form::label('sector_id', 'Client sector:', ['class' => 'required']) }}
			{{ Form::select('sector_id', $sectors, Input::old('sector_id')) }}
		</div>
		<div class="formfield">
			{{ Form::label('type_id', 'Client type:', ['class' => 'required']) }}
			{{ Form::select('type_id', $types, Input::old('type_id')) }}
		</div>
		<div class="formfield">
			{{ Form::label('service_id', 'Client service:', ['class' => 'required']) }}
			{{ Form::select('service_id', $services, Input::old('service_id')) }}
		</div>
	</div>
	<div class="col-4 last">
		<div class="formfield">
			{{ Form::label('status', 'Current status:', ['class' => 'required']) }}
			{{ Form::select('status', ['' => 'Please select...', 0 => 'Dormant', 1 => 'Active' ], Input::has('status') ? Input::old('status') : 1) }}
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