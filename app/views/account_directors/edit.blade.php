@extends('layouts.master')

@section('page-header')
Editing Account Direct: {{ $account_director->getFullName() }}
@stop

@section('page-nav')
<li><a href="{{ route('account_directors.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'account_directors/' . $account_director->id]) }}
<div class="row">
	<div class="col-6">
		<div class="formfield">
			{{ Form::label('first_name', 'First Name:', ['class' => 'required']) }}
			{{ Form::text('first_name', isset($account_director->first_name) ? $account_director->first_name : '') }}
		</div>
		<div class="formfield">
			{{ Form::label('last_name', 'Last  Name:', ['class' => 'required']) }}
			{{ Form::text('last_name', isset($account_director->last_name) ? $account_director->last_name : '') }}
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