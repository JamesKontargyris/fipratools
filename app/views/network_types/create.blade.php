@extends('layouts.master')

@section('page-header')
    Add a Network Type
@stop

@section('page-nav')
    <li><a href="{{ route('network_types.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'network_types.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Network Type Name:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name')) }}
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