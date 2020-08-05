@extends('layouts.master')

@section('page-header')
    Editing Reporting Category: {{ $type_category->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('type_categories.index') }}" class="primary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'type_categories/' . $type_category->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Type Reporting Category Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($type_category->name) ? $type_category->name : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('short_name', 'Type Reporting Category Short Name:', ['class' => 'required']) }}
                {{ Form::text('short_name', isset($type_category->short_name) ? $type_category->short_name : '') }}
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