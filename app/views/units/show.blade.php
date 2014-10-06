@extends('layouts.master')

@section('page-header')
{{ $unit->name }}
@stop

@section('page-nav')
<li><a href="/units/{{ $unit->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this unit</a></li>
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6">
		<h4>Address:</h4>
		<p>
			{{ $unit->address1 }}<br/>
			{{ ! empty($unit->address2) ? $unit->address2 . '<br/>' : '' }}
			{{ ! empty($unit->address3) ? $unit->address3 . '<br/>' : '' }}
			{{ ! empty($unit->address4) ? $unit->address4 . '<br/>' : '' }}
			{{ $unit->post_code }}
		</p>
		@if( ! empty($unit->phone))
			<h4>Telephone:</h4>
			<p>{{ $unit->phone }}</p>
		@endif
		@if( ! empty($unit->fax))
			<h4>Fax:</h4>
			<p>{{ $unit->fax }}</p>
		@endif
		@if( ! empty($unit->email))
			<h4>Email:</h4>
			<p>{{ $unit->email }}</p>
		@endif
	</div>
	<div class="col-6 last">
		@if($unit->post_code)
			<iframe
			  width="600"
			  height="450"
			  frameborder="0" style="border:0"
			  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyATzzmmT075GUyVS_4EGw_RJCGc7P77sUo&q={{ $unit->post_code }}">
			</iframe>
		@endif
	</div>
</div>
@stop