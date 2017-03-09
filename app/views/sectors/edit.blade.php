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
			{{ Form::label('category', 'Expertise category:', ['class' => 'required']) }}
			{{ Form::select('category', $categories, isset($sector->category_id) ? $sector->category_id : '', ['class' => 'required reveal-new-category select2', 'data-reveal' => 'new-category']) }}
		</div>
		<div class="formfield new-category hide">
			{{ Form::label('new_category', 'New expertise category:', ['class' => 'required']) }}
			{{ Form::text('new_category', null, ['class' => 'new-category']) }}
		</div>
	</div>
	<div class="col-6 last">
		<div class="formfield">
			{{ Form::label('show_list', 'Available in:', ['class' => 'required']) }}
			{{ Form::hidden('show_list', 0) }}
			<p>{{ Form::checkbox('show_list', isset($sector->show_list) ? : '', ($sector->show_list == 1) ? ['checked' => 'checked'] : []) }} Lead Office List</p>
			{{ Form::hidden('show_case', 0) }}
			<p>{{ Form::checkbox('show_case', isset($sector->show_case) ? : '', ($sector->show_case == 1) ? ['checked' => 'checked'] : []) }} Case Studies</p>
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