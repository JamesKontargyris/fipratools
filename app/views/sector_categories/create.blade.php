@extends('layouts.master')

@section('page-header')
Add an Expertise Category
@stop

@section('page-nav')
<li><a href="{{ route('sector_categories.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'sector_categories.store']) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('name', 'Expertise Category Name:', ['class' => 'required']) }}
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