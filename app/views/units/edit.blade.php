@extends('layouts.master')

@section('page-header')
Editing Unit: {{ $unit->name }}
@stop

@section('page-nav')
<li><a href="{{ route('units.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'units/' . $unit->id]) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Unit Name:', ['class' => 'required']) }}
			{{ Form::text('name', isset($unit->name) ? $unit->name : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('address', 'Address:', ['class' => 'required']) }}
			{{ Form::text('address1', isset($unit->address1) ? $unit->address1 : '') }}
			{{ Form::text('address2', isset($unit->address2) ? $unit->address2 : '') }}
			{{ Form::text('address3', isset($unit->address3) ? $unit->address3 : '') }}
			{{ Form::text('address4', isset($unit->address4) ? $unit->address4 : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('postcode', 'Zip / Post Code:', ['class' => 'required']) }}
            {{ Form::text('postcode', isset($unit->post_code) ? $unit->post_code : '') }}
		</div>
	</div>
	<div class="col-6 last">
		<div class="formfield">
			{{ Form::label('phone', 'Telephone:') }}
			{{ Form::text('phone', isset($unit->phone) ? $unit->phone : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('fax', 'Fax:') }}
			{{ Form::text('fax', isset($unit->fax) ? $unit->fax : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('email', 'Email:') }}
			{{ Form::email('email', isset($unit->email) ? $unit->email : '') }}
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Update', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>
@stop