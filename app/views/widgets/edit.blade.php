@extends('layouts.master')

@section('page-header')
    Editing Widget: {{ $widget->name }} ({{ $widget->slug }})
@stop

@section('page-nav')
    <li><a href="{{ route('widgets.index') }}" class="primary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'widgets/' . $widget->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($widget->name) ? $widget->name : '', ['class' => 'widget-name']) }}
            </div>
            <div class="formfield">
                {{ Form::label('slug', 'Slug:', ['class' => 'required']) }}
                {{ Form::text('slug', isset($widget->slug) ? $widget->slug : '', ['class' => 'slug-name']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('content', 'Content:') }}
                {{ Form::textarea('content', isset($widget->content) ? $widget->content : '', ['rows' => '10']) }}
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