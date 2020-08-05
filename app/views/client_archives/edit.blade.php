@extends('layouts.master')

@section('page-header')
Edit archive record for {{ $client->name }}
@stop

@section('page-nav')
<li><a href="{{ route('client_archives.index', ['client_id' => $client->id]) }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'client_archives/' . $client_archive->id]) }}
<div class="row">
	<div class="col-9">
		<div class="formfield">
			{{ Form::label('date', 'Date:', ['class' => 'required']) }}
			{{ Form::text('date', isset($client_archive->date) ? date('j F Y', strtotime($client_archive->date)) : '', ['class' => 'datepicker', 'id' => 'date']) }}
		</div>
		<div class="formfield">
			{{ Form::label('unit', 'Unit:', ['class' => 'required']) }}
			{{ Form::text('unit', isset($client_archive->unit) ? $client_archive->unit : '', [ 'id' => 'unit']) }}
		</div>
		<div class="formfield">
			{{ Form::label('account_director', 'Account Director:', ['class' => 'required']) }}
			{{ Form::text('account_director', isset($client_archive->account_director) ? $client_archive->account_director : '', ['id' => 'account_director']) }}
		</div>
		<div class="formfield">
			{{ Form::label('comment', 'Comment:', ['class' => 'required']) }}
			{{ Form::textarea('comment', isset($client_archive->comment) ? $client_archive->comment : '', ['cols' => '5']) }}
		</div>
		{{ Form::hidden('client_id', $client->id) }}
	</div>
</div>

<div class="row">
	<div class="col-12">
		{{ Form::submit('Update', ['class' => 'primary']) }}
		{{ Form::close() }}
	</div>
</div>
@stop