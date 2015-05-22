@extends('layouts.master')

@section('page-header')
    Add a Unit Reporting Group
@stop

@section('page-nav')
    <li><a href="{{ route('unit_groups.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'unit_groups.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Unit Group Name:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name')) }}
            </div>
            <div class="formfield">
                {{ Form::label('short_name', 'Unit Group Short Name:', ['class' => 'required']) }}
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