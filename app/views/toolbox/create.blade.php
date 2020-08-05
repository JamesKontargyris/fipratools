@extends('layouts.master')

@section('page-header')
    Add a Toolbox Resource
@stop

@section('page-nav')
    <li><a href="{{ route('toolbox.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    <div class="border-box fill section-toolbox">
        <div class="border-box__header">
            <i class="fa fa-link"></i> Add a Link
        </div>
        <div class="border-box__content">
            {{ Form::open(['route' => 'toolbox.store']) }}
            {{ Form::hidden('type', 'link') }}
            <div class="formfield">
                {{ Form::label('name', 'Link Name:', ['class' => 'required']) }}
                <div class="label-info">E.g. Fipra Flickr Photo Stream</div>
                {{ Form::text('name', Input::old('name')) }}
            </div>
            <div class="formfield">
                {{ Form::label('description', 'Link Description:', ['class' => 'required']) }}
                {{ Form::text('description', Input::old('description')) }}
            </div>
            <div class="formfield">
                {{ Form::label('url', 'URL:', ['class' => 'required']) }}
                <div class="label-info">E.g. http://www.fipra.com</div>
                {{ Form::text('url', Input::old('url')) }}
            </div>
            <div class="formfield">
                {{ Form::submit('Add Link', ['class' => 'primary']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="border-box fill section-toolbox">
        <div class="border-box__header">
            <i class="fa fa-file-text"></i> Add a File
        </div>
        <div class="border-box__content">
            {{ Form::open(['route' => 'toolbox.store', 'files' => true]) }}
            {{ Form::hidden('type', 'file') }}
            <div class="formfield">
                {{ Form::label('name', 'File Name:', ['class' => 'required']) }}
                <div class="label-info">E.g. Fipra-branded PowerPoint Template</div>
                {{ Form::text('name', Input::old('name')) }}
            </div>
            <div class="formfield">
                {{ Form::label('description', 'File Description:', ['class' => 'required']) }}
                {{ Form::text('description', Input::old('description')) }}
            </div>
            <div class="formfield">
                {{ Form::label('file', 'File:', ['class' => 'required']) }}
                <div class="label-info">Max. upload size: 100mb</div>
                {{ Form::file('file') }}
            </div>
            <div class="formfield">
                {{ Form::submit('Add File', ['class' => 'primary']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop