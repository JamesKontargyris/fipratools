@extends('layouts.master')

@section('page-header')
    Add a Widget
@stop

@section('page-nav')
    <li><a href="{{ route('widgets.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'widgets.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Name:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name'), ['class' => 'widget-name']) }}
            </div>
            <div class="formfield">
                {{ Form::label('slug', 'Slug:', ['class' => 'required']) }}
                {{ Form::text('slug', Input::old('slug'), ['class' => 'widget-slug']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('content', 'Content:') }}
                {{ Form::textarea('content', Input::old('content')) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{ Form::submit('Add', ['class' => 'primary']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop