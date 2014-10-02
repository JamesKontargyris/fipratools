@extends('layouts.master')

@section('content')
<h2>Add a new Fipra Unit</h2>

@include('layouts.partials.messages')

<div class="col-6">
	{{ Form::open(['route' => 'unit.store']) }}
	<div class="formfield">
		{{ Form::label('name', 'Unit Name:') }}
		{{ Form::text('name', Input::old('name')) }}
	</div>
	{{ Form::submit('Add', ['class' => 'primary']) }}
	{{ Form::close() }}
</div>
@stop