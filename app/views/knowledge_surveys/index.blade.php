@extends('layouts.master')

@section('page-header')
    Knowledge Profiles
@stop

@section('page-nav')
@stop

@section('content')

    @include('layouts.partials.messages')

    @if(! $user_info->survey_updated && $user_info->date_of_birth != '0000-00-00')
        {{--The survey_updated flag is negative but survey responses exist, so this profile must be updated--}}
        <div class="row no-margin">
            <div class="col-12">
                <div class="alert-container">
                    <div class="alert alert-warning alert-big-text">
                        <strong>Your profile is out of date and/or requires an update.</strong><br>
                        <a href="/survey/profile/edit" class="primary">Update your knowledge profile</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">Stats and interactive elements will appear on this page</div>
    </div>

@stop