@extends('layouts.master')

@section('page-header')
    Editing Reporting Group: {{ $unit_group->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('unit_groups.index') }}" class="primary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'unit_groups/' . $unit_group->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Unit Group Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($unit_group->name) ? $unit_group->name : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('short_name', 'Unit Group Short Name:', ['class' => 'required']) }}
                {{ Form::text('short_name', isset($unit_group->short_name) ? $unit_group->short_name : '') }}
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