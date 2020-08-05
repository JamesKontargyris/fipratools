@extends('layouts.master')

@section('page-header')
    Add a Type Reporting Category
@stop

@section('page-nav')
    <li><a href="{{ route('type_categories.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'type_categories.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Type Reporting Category Name:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name')) }}
            </div>
            <div class="formfield">
                {{ Form::label('short_name', 'Type Reporting Category Short Name:', ['class' => 'required']) }}
                {{ Form::text('short_name', Input::old('short_name')) }}
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