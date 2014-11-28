@extends('layouts.status_check')

@section('page-header')
Client Status Update Completed
@stop

@section('content')
<div class="row">
	<div class="col-9">
		<h3>Thank you! Your clients have been updated.</h3>
		<p><a class="primary" href="/list">View the Lead Office List</a> <a class="primary" href="/clients">Review your clients</a></p>
	</div>
</div>
@stop