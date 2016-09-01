@extends('layouts.master')

@section('page-header')
Add an Account Director
@stop

@section('page-nav')
<li><a href="{{ route('account_directors.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'account_directors.store']) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('first_name', 'First Name:', ['class' => 'required']) }}
			{{ Form::text('first_name', Input::old('first_name')) }}
		</div>
		<div class="formfield">
			{{ Form::label('last_name', 'Last Name:', ['class' => 'required']) }}
			{{ Form::text('last_name', Input::old('last_name')) }}
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