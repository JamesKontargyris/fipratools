@extends('layouts.master')

@section('page-header')
    Editing Case Study: {{ $case->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('cases.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'cases/' . $case->id]) }}
    {{ Form::hidden('status', isset($case->status) ? $case->status : 0) }}

    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Basic background on case:', ['class' => 'required']) }}
                {{ Form::text('name', isset($case->name) ? $case->name : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('challenges', 'Challenges facing client / Fipra:', ['class' => 'required']) }}
                {{ Form::text('challenges', isset($case->challenges) ? $case->challenges : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('strategy', 'What Fipra did to overcome the challenges:', ['class' => 'required']) }}
                {{ Form::text('strategy', isset($case->strategy) ? $case->strategy : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('result', 'End result:', ['class' => 'required']) }}
                {{ Form::text('result', isset($case->result) ? $case->result : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('year', 'Year:', ['class' => 'required']) }}
                {{ Form::text('year', isset($case->year) ? $case->year : '') }}
            </div>
            <div class="formfield">
                {{ Form::label('client', 'Client (leave blank if anonymous):') }}
                {{ Form::text('client', isset($case->client) ? $case->client : '') }}
            </div>
            @if($user->hasRole('Administrator'))
                <div class="formfield">
                    {{ Form::label('unit_id', 'Link to Unit:', ['class' => 'required']) }}
                    {{ Form::select('unit_id', $units, isset($case->unit_id) ? $case->unit_id : '', ['class' => 'unit-selection']) }}
                </div>
            @else
                {{ Form::hidden('unit_id', isset($case->unit_id) ? $case->unit_id : '') }}
            @endif
            {{ Form::hidden('user_id', isset($case->user_id) ? $case->user_id : '') }}

            <div class="formfield">
                {{ Form::label('account_director_id', 'The Account Director to speak to:', ['class' => 'required']) }}
                {{ Form::select('account_director_id', $account_directors, isset($case->account_director_id) ? $case->account_director_id : '') }}
            </div>
        </div>
        <div class="col-6 last">
            <div class="formfield">
                {{ Form::label('sector_id', 'Sector(s):', ['class' => 'required']) }}
                {{ Form::select('sector_id[]', $sectors, isset($case->sector_id) ? unserialize($case->sector_id) : '', ['id' => 'sector_select', 'multiple' => 'multiple']) }}
            </div>
            <div class="formfield">
                {{ Form::label('product_id', 'Product(s):', ['class' => 'required']) }}
                {{ Form::select('product_id[]', $products, isset($case->product_id) ? unserialize($case->product_id) : '', ['id' => 'product_select', 'multiple' => 'multiple']) }}
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