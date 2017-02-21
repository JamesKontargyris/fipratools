@extends('layouts.master')

@section('page-header')
About the Lead Office List
@stop

@section('content')
    <div class="row prose">
        <div class="col-9">
            {{ get_widget('lol_about_us') }}
        </div>
    </div>
@stop