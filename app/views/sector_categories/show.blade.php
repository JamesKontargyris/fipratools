@extends('layouts.master')

@section('page-header')
{{ $sector_category->name }}
@stop

@section('page-nav')
<li><a href="/sectors/{{ $sector_category->id }}/edit" class="primary"><i class="fa fa-pencil"></i> Edit this sector category</a></li>
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')
@stop