@extends('layouts.master')

@section('page-header')
    Add a Product
@stop

@section('page-nav')
    <li><a href="{{ route('products.index') }}" class="primary"><i class="fa fa-caret-left"></i> Overview</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['route' => 'products.store']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('name', 'Product Name:', ['class' => 'required']) }}
                {{ Form::text('name', Input::old('name')) }}
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