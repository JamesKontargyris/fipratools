@extends('layouts.master')

@section('page-header')
    Editing Language: {{ $language->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_languages.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'knowledge_languages/' . $language->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Language:', ['class' => 'required']) }}
                {{ Form::text('name', isset($language->name) ? $language->name : '') }}
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