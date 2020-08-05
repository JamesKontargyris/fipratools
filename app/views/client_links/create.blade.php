@extends('layouts.master')

@section('page-header')
Create a Client Link
@stop

@section('page-nav')
<li><a href="{{ route('clients.index') }}" class="primary"><i class="fa fa-caret-left"></i> Clients Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'client_links.store']) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('unit_1', 'First Network Member:', ['class' => 'required']) }}
			@if(isset($unit_1->name))
				<h3><strong>{{ $unit_1->name }}</strong></h3>
				{{ Form::hidden('unit_1', $unit_1->id, ['readonly' => 'readonly']) }}
			@else
				{{ Form::select('unit_1', $units, Input::old('unit_1'), ['class' => 'required unit select2']) }}
			@endif
		</div>
		<div class="formfield">
			{{ Form::label('client_1', 'First Client:', ['class' => 'required']) }}
			@if(isset($client_1->name))
				<h3><strong>{{ $client_1->name }}</strong></h3>
				{{ Form::hidden('client_1', $client_1->id, ['readonly' => 'readonly']) }}
			@else
				{{ Form::select('client_1', ['' => 'Please select a unit...'], Input::old('client_1'), ['class' => 'required clients select2']) }}
			@endif
		</div>
	</div>
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('unit_2', 'Second Network Member:', ['class' => 'required']) }}
			{{ Form::select('unit_2', $units, Input::old('unit_2'), ['class' => 'required unit select2']) }}
		</div>
		<div class="formfield">
			{{ Form::label('client_2', 'Second Client:', ['class' => 'required']) }}
			{{ Form::select('client_2', ['' => 'Please select a unit...'], Input::old('client_2'), ['class' => 'required clients select2']) }}
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