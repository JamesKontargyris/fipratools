@extends('layouts.master')

@section('page-header')
    Editing Case Study: {{ $case->name }}
@stop

@section('page-nav')
    <li><a href="{{ route('cases.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'PUT', 'url' => 'cases/' . $case->id]) }}
    {{ Form::hidden('status', isset($case->status) ? $case->status : 0) }}

    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Basic background on case:', ['class' => 'required']) }}
                {{ Form::textarea('name', isset($case->name) ? $case->name : '', ['rows' => '5']) }}
            </div>
            <div class="formfield">
                {{ Form::label('challenges', 'Challenges facing client / Fipra:', ['class' => 'required']) }}
                {{ Form::textarea('challenges', isset($case->challenges) ? $case->challenges : '', ['rows' => '5']) }}
            </div>
            <div class="formfield">
                {{ Form::label('strategy', 'What Fipra did to overcome the challenges:', ['class' => 'required']) }}
                {{ Form::textarea('strategy', isset($case->strategy) ? $case->strategy : '', ['rows' => '5']) }}
            </div>
            <div class="formfield">
                {{ Form::label('result', 'End result:', ['class' => 'required']) }}
                {{ Form::textarea('result', isset($case->result) ? $case->result : '', ['rows' => '5']) }}
            </div>
        </div>
        <div class="col-6 last">
            <div class="formfield">
                {{ Form::label('year', 'Year:', ['class' => 'required']) }}
                {{ Form::text('year', isset($case->year) ? $case->year : '', ['style' => 'display:block; width:25%']) }}
            </div>
            <div class="formfield client-select">
                {{ Form::label('client', 'Client:') }}
                {{ Form::select('client_id', $clients, isset($case->client_id) ? $case->client_id : '', ['class' => 'select2', 'style' => "width:100%;"]) }}
            </div>
            @if($user->hasRole('Administrator'))
                <div class="formfield">
                    {{ Form::label('unit_id', 'Link to Unit:', ['class' => 'required']) }}
                    {{ Form::select('unit_id', $units, isset($case->unit_id) ? $case->unit_id : '', ['class' => 'unit-selection select2', 'style' => 'width:100%;']) }}
                </div>
            @else
                {{ Form::hidden('unit_id', isset($case->unit_id) ? $case->unit_id : '', ['style' => 'width:100%;']) }}
            @endif
            {{ Form::hidden('user_id', isset($case->user_id) ? $case->user_id : '', ['style' => 'width:100%;']) }}

            <div class="formfield">
                {{ Form::label('account_director_id', 'The Account Director at the time:', ['class' => 'required']) }}
                {{ Form::select('account_director_id', $account_directors, isset($case->account_director_id) ? $case->account_director_id : '', ['class' => 'select2']) }}
            </div>
            <div class="formfield">
                {{ Form::label('sector_id', 'Sector(s):', ['class' => 'required']) }}
                {{ Form::select('sector_id[]', $sectors, isset($case->sector_id) ? unserialize($case->sector_id) : '', ['class' => 'select2', 'multiple' => 'multiple']) }}
            </div>
            <div class="formfield">
                {{ Form::label('product_id', 'Product(s):', ['class' => 'required']) }}
                {{ Form::select('product_id[]', $products, isset($case->product_id) ? unserialize($case->product_id) : '', ['class' => 'select2', 'multiple' => 'multiple']) }}
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