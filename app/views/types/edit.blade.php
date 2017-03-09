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
		<div class="formfield">
			{{ Form::label('short_name', 'Type Name:', ['class' => 'required']) }}
			{{ Form::text('short_name', isset($type->short_name) ? $type->short_name : '') }}
		</div>
        <div class="formfield">
            {{ Form::label('type_category', 'Reporting Category:', ['class' => 'required']) }}
            {{ Form::select('type_category', $type_categories, isset($type->category_id) ? $type->category_id : '', ['class' => 'select2', 'style' => 'width:100%;']) }}
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