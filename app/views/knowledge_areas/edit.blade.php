@extends('layouts.master')

@section('page-header')
    Editing Area: {{ $area->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_area_groups.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'knowledge_areas/' . $area->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($area->name) ? $area->name : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('knowledge_area_group_id', 'Include in group:', ['class' => 'required']) }}
                {{ Form::select('knowledge_area_group_id', $groups, isset($area->knowledge_area_group_id) ? $area->knowledge_area_group_id : '') }}
            </div>
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