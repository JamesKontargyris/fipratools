@extends('layouts.master')

@section('page-header')
@if(is_search()) Searching for: {{ $items->search_term }} @else Reports @endif
@stop

@section('page-nav')
@stop

@section('content')
<div class="row">
	<p>Coming soon...</p>
</div>
@stop