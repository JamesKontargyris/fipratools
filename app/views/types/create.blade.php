@extends('layouts.master')

@section('page-header')
Add a Unit
@stop

@section('page-nav')
<li><a href="{{ route('types.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'types.store']) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Type Name:', ['class' => 'required']) }}
			{{ Form::text('name', Input::old('name')) }}
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