@extends('layouts.master')

@section('page-header')
Editing Type: {{ $type->name }}
@stop

@section('page-nav')
<li><a href="{{ route('types.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'types/' . $type->id]) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Type Name:', ['class' => 'required']) }}
			{{ Form::text('name', isset($type->name) ? $type->name : '') }}
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