@extends('layouts.master')

@section('page-header')
Add a Sector
@stop

@section('page-nav')
<li><a href="{{ route('sectors.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
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
			{{ Form::label('category', 'Expertise category:', ['class' => 'required']) }}
			{{ Form::select('category', $categories, Input::old('category'), ['class' => 'required reveal-new-category select2', 'data-reveal' => 'new-category', 'style' => 'width:100%']) }}
		</div>
		<div class="formfield new-category hide">
			{{ Form::label('new_category', 'New expertise category:', ['class' => 'required']) }}
			{{ Form::text('new_category', Input::old('new_category'), ['class' => 'new-category']) }}
		</div>
	</div>
	<div class="col-6 last">
		<div class="formfield">
			{{ Form::label('show_list', 'Available in:', ['class' => 'required']) }}
			{{ Form::hidden('show_list', 0) }}
			<p>{{ Form::checkbox('show_list', input::old('show_list'), true) }} Lead Office List</p>
			{{ Form::hidden('show_case', 0) }}
			<p>{{ Form::checkbox('show_case', input::old('show_case'), true) }} Case Studies</p>
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