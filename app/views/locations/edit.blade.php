@extends('layouts.master')

@section('page-header')
    Editing Location: {{ $location->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('locations.index') }}" class="primary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'locations/' . $location->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Location Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($location->name) ? $location->name : '') }}
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