@extends('layouts.master')

@section('page-header')
{{ $client->name }}
@stop

@section('page-nav')
@if($user->unit_id == $client->unit_id)
	<li><a href="/sectors/{{ $client->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this client</a></li>
@endif
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6 border-box fill">
		<h3>Lead Unit</h3>
		<h4>{{ $client->unit()->pluck('name') }}</h4>
		<p>{{ $client->getLeadOfficeAddress() }}</p>
		<h4>Account Director to talk to</h4>
		<p>{{ $client->account_director }}</p>
	</div>
	<div class="col-6 last">
		<h3>Comments</h3>
		<p>{{ $client->comments }}</p>
		<h4>Details</h4>
		<p><strong>Sector:</strong> {{ $client->sector()->pluck('name') }}</p>
		<p><strong>Type:</strong> {{ $client->type()->pluck('name') }}</p>
		<p><strong>Service:</strong> {{ $client->service()->pluck('name') }}</p>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<h3>Archive</h3>
	</div>
</div>

@stop