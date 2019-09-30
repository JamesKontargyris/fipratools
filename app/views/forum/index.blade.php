@extends('layouts.forum')

@section('page-header')
	Fipra Forum
@stop

@section('content')
{{--@include('forum.partials.breadcrumbs')--}}

@if(get_widget('forum_intro'))
	<p>{{ nl2br(get_widget('forum_intro')) }}</p>
@endif

@stop