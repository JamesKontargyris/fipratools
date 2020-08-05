@extends('layouts.master')

@section('page-header')
Add a Type
@stop

@section('page-nav')
<li><a href="{{ route('types.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
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
		<div class="formfield">
			{{ Form::label('short_name', 'Short Name:', ['class' => 'required']) }}
			{{ Form::text('short_name', Input::old('short_name')) }}
		</div>
        <div class="formfield">
            {{ Form::label('type_category', 'Reporting Category:', ['class' => 'required']) }}
            {{ Form::select('type_category', $type_categories, Input::old('type_category'), ['class' => 'select2', 'style' => 'width:100%;']) }}
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