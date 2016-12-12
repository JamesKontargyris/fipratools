@extends('layouts.master')

@section('page-header')
    Add a Knowledge Area
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_areas.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'knowledge_areas.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Name:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name')) }}
            </div>
            <div class="formfield">
                {{ Form::label('knowledge_area_group_id', 'Include in group:', ['class' => 'required']) }}
                {{ Form::select('knowledge_area_group_id', $groups, Input::old('knowledge_area_group_id')) }}
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