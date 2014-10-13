@extends('layouts.master')

@section('page-header')
Edit archive record for {{ $client->name }}
@stop

@section('page-nav')
<li><a href="{{ route('client_archives.index', ['client_id' => $client->id]) }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

{{ Form::open(['method' => 'PUT', 'url' => 'client_archives/' . $client_archive->id]) }}
<div class="row">
	<div class="col-12">
		<h3>This record covers:</h3>
		<div class="col-6">
			<div class="formfield">
				{{ Form::label('start_date', 'Start date:', ['class' => 'required']) }}
				{{ Form::text('start_date', isset($client_archive->start_date) ? date('j F Y', strtotime($client_archive->start_date)) : '', ['class' => 'datepicker start_date']) }}
			</div>
		</div>
		<div class="col-6 last">
			<div class="formfield">
				{{ Form::label('end_date', 'End date:', ['class' => 'required']) }}
				{{ Form::text('end_date', isset($client_archive->end_date) ? date('j F Y', strtotime($client_archive->end_date)) : '', ['class' => 'datepicker end_date']) }}
			</div>
		</div>
		<div class="formfield">
			{{ Form::label('comment', 'Details:', ['class' => 'required']) }}
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