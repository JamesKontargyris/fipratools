@extends('layouts.master')

@section('page-header')
    Add a Language
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_languages.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'knowledge_languages.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Language:', ['class' => 'required']) }}
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