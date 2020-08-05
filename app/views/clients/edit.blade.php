@extends('layouts.master')

@section('page-header')
Editing Client: {{ $client->name }}
@stop

@section('page-nav')
<li><a href="{{ route('clients.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'clients/' . $client->id]) }}
<div class="row">
	<div class="col-8">
		<div class="formfield">
			{{ Form::label('name', 'Client name:', ['class' => 'required']) }}
			{{ Form::text('name', isset($client->name) ? $client->name : '') }}
		</div>
		@if($user->hasRole('Administrator'))
			<div class="formfield">
				{{ Form::label('unit_id', 'Link to unit:', ['class' => 'required']) }}
				{{ Form::select('unit_id', $units, isset($client->unit_id) ? $client->unit_id : '', ['class' => 'unit-selection select2', 'style' => 'width:100%;']) }}
			</div>
		@else
			{{ Form::hidden('unit_id', isset($client->unit_id) ? $client->unit_id : '') }}
			{{ Form::hidden('unit_name', $user->unit()->pluck('name')) }}
		@endif
		{{ Form::hidden('user_id', isset($client->user_id) ? $client->user_id : '') }}

		<div class="formfield show-uk">
			{{ Form::label('pr_client', 'Mainly PR client?', ['class' => 'required']) }}
			{{ Form::select('pr_client', [0 => 'No', 1 => 'Yes'], isset($client->pr_client) ? $client->pr_client : 0, ['disabled' => 'disabled', 'class' => 'pr-client-selection']) }}
		</div>
		<div class="formfield">
			{{ Form::label('account_director_id', 'The Account Director to speak to:', ['class' => 'required']) }}
			{{ Form::select('account_director_id', $account_directors, isset($client->account_director_id) ? $client->account_director_id : '', ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('sector_id', 'Client sector:', ['class' => 'required']) }}
			{{ Form::select('sector_id', $sectors, isset($client->sector_id) ? $client->sector_id : '', ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('type_id', 'Client type:', ['class' => 'required']) }}
			{{ Form::select('type_id', $types, isset($client->type_id) ? $client->type_id : '', ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
		<div class="formfield">
			{{ Form::label('service_id', 'Client service:', ['class' => 'required']) }}
			{{ Form::select('service_id', $services, isset($client->service_id) ? $client->service_id : '', ['class' => 'select2', 'style' => 'width:100%;']) }}
		</div>
	</div>
	<div class="col-4 last">
		{{ Form::hidden('status', $client->status) }}

		<div class="formfield">
			{{ Form::label('comments', 'Comments:') }}
			{{ Form::textarea('comments', isset($client->comments) ? $client->comments : '') }}
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Edit', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>
@stop