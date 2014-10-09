@extends('layouts.master')

@section('page-header')
Add a Sector
@stop

@section('page-nav')
<li><a href="{{ route('sectors.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'sectors.store']) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Sector Name:', ['class' => 'required']) }}
			{{ Form::text('name', Input::old('name'), ['class' => 'sector-name']) }}
		</div>
		<div class="formfield">
			{{ Form::label('category', 'Reporting category:', ['class' => 'required']) }}
			{{ Form::select('category', $categories, Input::old('category'), ['class' => 'required reveal-new-category', 'data-reveal' => 'new-category']) }}
		</div>
		<div class="formfield new-category hide">
			{{ Form::label('new_category', 'New reporting category:', ['class' => 'required']) }}
			{{ Form::text('new_category', Input::old('new_category'), ['class' => 'new-category']) }}
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