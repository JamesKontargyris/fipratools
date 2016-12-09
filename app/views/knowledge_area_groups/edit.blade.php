@extends('layouts.master')

@section('page-header')
    Editing Group: {{ $group->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_area_groups.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Return to overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'knowledge_area_groups/' . $group->id]) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Name:', ['class' => 'required']) }}
                {{ Form::text('name', isset($group->name) ? $group->name : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('order', 'Order:', ['class' => 'required']) }}
                {{ Form::text('order', isset($group->order) ? $group->order : '10', ['style' => 'width:75px']) }}
                <div class="small-text">The higher the number, the &quot;heavier&quot; the group. Heavier groups appear further down the page.</div>
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