@extends('layouts.master')

@section('page-header')
Editing Sector Category: {{ $sector_category->name }}
@stop

@section('page-nav')
<li><a href="{{ route('sector_categories.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'sector_categories/' . $sector_category->id]) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Sector Category Name:', ['class' => 'required']) }}
			{{ Form::text('name', isset($sector_category->name) ? $sector_category->name : '') }}
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