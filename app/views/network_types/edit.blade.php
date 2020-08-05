@extends('layouts.master')

@section('page-header')
    Editing Network Type: {{ $network_type->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('network_types.index') }}" class="primary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'network_types/' . $network_type->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Network Type Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($network_type->name) ? $network_type->name : '') }}
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