@extends('layouts.master')

@section('page-header')
Editing Account Direct: {{ $account_director->getFullName() }}
@stop

@section('page-nav')
<li><a href="{{ route('account_directors.index') }}" class="primary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'account_directors/' . $account_director->id]) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('first_name', 'First Name:', ['class' => 'required']) }}
			{{ Form::hidden('first_name_old', isset($account_director->first_name) ? $account_director->first_name : '') }}
			{{ Form::text('first_name', isset($account_director->first_name) ? $account_director->first_name : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('last_name', 'Last  Name:', ['class' => 'required']) }}
			{{ Form::hidden('last_name_old', isset($account_director->last_name) ? $account_director->last_name : '') }}
			{{ Form::text('last_name', isset($account_director->last_name) ? $account_director->last_name : '') }}
		</div>
	</div>
	<div class="col-6 last">
		<div class="formfield">
			{{ Form::label('show_list', 'Available in:', ['class' => 'required']) }}
			{{ Form::hidden('show_list', 0) }}
			<p>{{ Form::checkbox('show_list', isset($account_director->show_list) ? : '', ($account_director->show_list == 1) ? ['checked' => 'checked'] : []) }} Lead Office List</p>
			{{ Form::hidden('show_case', 0) }}
			<p>{{ Form::checkbox('show_case', isset($account_director->show_case) ? : '', ($account_director->show_case == 1) ? ['checked' => 'checked'] : []) }} Case Studies</p>
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