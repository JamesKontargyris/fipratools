@extends('layouts.master')

@section('page-header')
Editing Sector: {{ $sector->name }}
@stop

@section('page-nav')
<li><a href="{{ route('sectors.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'sectors/' . $sector->id]) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Sector Name:', ['class' => 'required']) }}
			{{ Form::text('name', isset($sector->name) ? $sector->name : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('category', 'Reporting category:', ['class' => 'required']) }}
			{{ Form::select('category', $categories, isset($sector->category_id) ? $sector->category_id : '', ['class' => 'required reveal-new-category', 'data-reveal' => 'new-category']) }}
		</div>
		<div class="formfield new-category hide">
			{{ Form::label('new_category', 'New reporting category:', ['class' => 'required']) }}
			{{ Form::text('new_category', null, ['class' => 'new-category']) }}
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