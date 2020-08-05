@extends('layouts.master')

@section('page-header')
    Editing: {{ $edit_toolbox->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('toolbox.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    @if($edit_toolbox->type == 'link')

        <div class="border-box fill section-toolbox">
            <div class="border-box__content">
                {{ Form::open(['method' => 'PUT', 'url' => 'toolbox/' . $edit_toolbox->id]) }}
                {{ Form::hidden('type', 'link') }}
                <div class="formfield">
                    {{ Form::label('name', 'Link Name:', ['class' => 'required']) }}
                    <div class="label-info">E.g. Fipra Flickr Photo Stream</div>
                    {{ Form::text('name', isset($edit_toolbox->name) ? $edit_toolbox->name : '') }}
                </div>
                <div class="formfield">
                    {{ Form::label('description', 'Link Description:', ['class' => 'required']) }}
                    {{ Form::text('description', isset($edit_toolbox->description) ? $edit_toolbox->description : '') }}
                </div>
                <div class="formfield">
                    {{ Form::label('url', 'URL:', ['class' => 'required']) }}
                    <div class="label-info">E.g. http://www.fipra.com</div>
                    {{ Form::text('url', isset($edit_toolbox->url) ? $edit_toolbox->url : '') }}
                </div>
                <div class="formfield">
                    {{ Form::submit('Update Link', ['class' => 'primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    @endif

    @if($edit_toolbox->type == 'file')
        <div class="border-box fill section-toolbox">
            <div class="border-box__content">
                {{ Form::open(['method' => 'PUT', 'url' => 'toolbox/' . $edit_toolbox->id]) }}
                {{ Form::hidden('type', 'file') }}
                <div class="formfield">
                    {{ Form::label('name', 'File Name:', ['class' => 'required']) }}
                    <div class="label-info">E.g. Fipra-branded PowerPoint Template</div>
                    {{ Form::text('name', isset($edit_toolbox->name) ? $edit_toolbox->name : '') }}
                </div>
                <div class="formfield">
                    {{ Form::label('description', 'File Description:', ['class' => 'required']) }}
                    {{ Form::text('description', isset($edit_toolbox->description) ? $edit_toolbox->description : '') }}
                </div>
                <div class="formfield">
                    Filename and path: <strong>{{ $edit_toolbox->file }}</strong>
                    {{ Form::hidden('file', $edit_toolbox->file) }}
                </div>
                <div class="formfield">
                    {{ Form::submit('Update File', ['class' => 'primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endif
@stop