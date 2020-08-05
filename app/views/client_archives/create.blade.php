@extends('layouts.master')

@section('page-header')
Add an archive record for {{ $client->name }}
@stop

@section('page-nav')
<li><a href="{{ route('client_archives.index', ['client_id' => $client->id]) }}" class="primary"><i class="fa fa-caret-left"></i> Archive Records Overview</a></li>
<li><a href="{{ route('clients.index', ['client_id' => $client->id]) }}" class="primary"><i class="fa fa-caret-left"></i> Clients Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['route' => 'client_archives.store']) }}
<div class="row">
	<div class="col-9">
		<div class="formfield">
			{{ Form::label('date', 'Date:', ['class' => 'required']) }}
			{{ Form::text('date', Input::old('date'), ['class' => 'datepicker', 'id' => 'date']) }}
		</div>
		<div class="formfield">
			{{ Form::label('unit', 'Unit:', ['class' => 'required']) }}
			{{ Form::text('unit', (Input::old('unit')) ? Input::old('unit') : $client->unit()->pluck('name'), [ 'id' => 'unit']) }}
		</div>
		<div class="formfield">
			{{ Form::label('account_director', 'Account Director:', ['class' => 'required']) }}
			{{ Form::text('account_director', (Input::old('account_director')) ? Input::old('account_director') : $client->account_director()->pluck('first_name') . ' ' . $client->account_director()->pluck('last_name'), ['id' => 'account_director']) }}
		</div>
		<div class="formfield">
			{{ Form::label('comment', 'Comment:', ['class' => 'required']) }}
			{{ Form::textarea('comment', Input::old('comment'), ['cols' => '5']) }}
		</div>
		{{ Form::hidden('client_id', $client->id) }}
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Add', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>
@stop