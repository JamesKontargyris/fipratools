@extends('layouts.master')

@section('page-header')
Add a Unit
@stop

@section('page-nav')
<li><a href="{{ route('units.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'units.store']) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Unit Name:', ['class' => 'required']) }}
			{{ Form::text('name', Input::old('name')) }}
		</div>
		<div class="formfield">
			{{ Form::label('address', 'Address:') }}
			{{ Form::text('address1', Input::old('address1')) }}
			{{ Form::text('address2', Input::old('address2')) }}
			{{ Form::text('address3', Input::old('address3')) }}
			{{ Form::text('address4', Input::old('address4')) }}
		</div>
		<div class="formfield">
			{{ Form::label('postcode', 'Zip / Post Code:') }}
            {{ Form::text('postcode', Input::old('postcode')) }}
		</div>
	</div>
	<div class="col-6 last">
		<div class="formfield">
			{{ Form::label('short_name', 'Short Name:', ['class' => 'required']) }}
			{{ Form::text('short_name', Input::old('short_name')) }}
		</div>
		<div class="formfield">
			{{ Form::label('phone', 'Telephone:') }}
			{{ Form::text('phone', Input::old('phone')) }}
		</div>
		<div class="formfield">
			{{ Form::label('fax', 'Fax:') }}
			{{ Form::text('fax', Input::old('fax')) }}
		</div>
		<div class="formfield">
			{{ Form::label('email', 'Email:') }}
			{{ Form::email('email', Input::old('email')) }}
		</div>
        <div class="formfield">
            {{ Form::label('unit_group', 'Reporting Group:', ['class' => 'required']) }}
            {{ Form::select('unit_group', $unit_groups, Input::old('unit_group'), ['class' => 'required']) }}
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