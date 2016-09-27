@extends('layouts.master')

@section('page-header')
    Add a Case Study
@stop

@section('page-nav')
    <li><a href="{{ route('cases.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'cases.store']) }}
    {{--If the current user is an Administrator, automatically approve this case study--}}
    @if($user->hasRole('Administrator'))
        {{ Form::hidden('status', 1) }}
    @else
        {{--Otherwise, mark it as pending--}}
        {{ Form::hidden('status', 0) }}
    @endif

    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Basic background on case:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name')) }}
            </div>
            <div class="formfield">
                {{ Form::label('challenges', 'Challenges facing client / Fipra:', ['class' => 'required']) }}
                {{ Form::text('challenges', Input::old('challenges')) }}
            </div>
            <div class="formfield">
                {{ Form::label('strategy', 'What Fipra did to overcome the challenges:', ['class' => 'required']) }}
                {{ Form::text('strategy', Input::old('strategy')) }}
            </div>
            <div class="formfield">
                {{ Form::label('result', 'End result:', ['class' => 'required']) }}
                {{ Form::text('result', Input::old('result')) }}
            </div>
            <div class="formfield">
                {{ Form::label('year', 'Year:', ['class' => 'required']) }}
                {{ Form::text('year', Input::old('year')) }}
            </div>
            <div class="formfield">
                {{ Form::label('client', 'Client (leave blank if anonymous):') }}
                {{ Form::text('client', Input::old('client')) }}
            </div>
            @if($user->hasRole('Administrator'))
                <div class="formfield">
                    {{ Form::label('unit_id', 'Link to Unit:', ['class' => 'required']) }}
                    {{ Form::select('unit_id', $units, Input::old('unit_id'), ['class' => 'unit-selection']) }}
                </div>
            @else
                {{ Form::hidden('unit_id', $user->unit()->pluck('id')) }}
            @endif
            {{ Form::hidden('user_id', $user->id) }}

            <div class="formfield">
                {{ Form::label('account_director_id', 'The Account Director to speak to:', ['class' => 'required']) }}
                {{ Form::select('account_director_id', $account_directors, Input::old('account_director_id')) }}
            </div>
        </div>
        <div class="col-6 last">
            <div class="formfield">
                {{ Form::label('sector_id', 'Sector(s):', ['class' => 'required']) }}
                {{ Form::select('sector_id[]', $sectors, Input::old('sector_id'), ['id' => 'sector_select', 'multiple' => 'multiple']) }}
            </div>
            <div class="formfield">
                {{ Form::label('product_id', 'Product(s):', ['class' => 'required']) }}
                {{ Form::select('product_id[]', $products, Input::old('product_id'), ['id' => 'product_select', 'multiple' => 'multiple']) }}
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