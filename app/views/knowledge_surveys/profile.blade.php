@extends('layouts.master')

@section('page-header')
    Your Knowledge Profile
@stop

@section('page-nav')
@stop

@section('content')

    @include('layouts.partials.messages')

    {{--Does the survey_updated flag indicate that the profile doesn't exist or needs to be updated?--}}
    @if($user_info->survey_updated)
        {{--Profile is up to date--}}
        <div class="row no-margin">
            <div class="col-12">
                <div class="alert-container">
                    <div class="alert alert-info">
                        <button class="close"><i class="fa fa-close"></i></button>
                        <strong>Your profile was last updated on {{ date('j F Y', strtotime($user_info->knowledge_profile_last_updated)) }}.</strong><br><a href="/survey/profile/edit" class="primary">Update your knowledge profile</a>
                    </div>
                </div>
            </div>
        </div>
    @elseif(! $user_info->survey_updated && $user_info->date_of_birth != '0000-00-00')
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
    @else
        {{--Otherwise, the profile does not yet exist and needs to be completed--}}
        <div class="row">
            <div class="col-12">
                <div class="alert-container">
                    <div class="alert alert-error alert-big-text">
                        <strong>Your profile is not yet complete.</strong><br>
                        <a href="/survey/profile/edit" class="primary">Complete your knowledge profile</a>
                    </div>
                </div>
            </div>
        </div>

        {{ get_widget('knowledge_survey_intro') }}

    @endif

    @if($user_info->date_of_birth != '0000-00-00')
        <div class="row">
            <div class="col-5">
                <table class="knowledge-profile-details">
                    <tr>
                        <td valign="top" class="knowledge-profile-details__title min-height">Date of Birth</td>
                        <td valign="top">{{ date('j F Y', strtotime($user_info->date_of_birth)) }} <br><em>{{ calculate_age($user_info->date_of_birth) }} years old</em></td>
                    </tr>
                    <tr>
                        <td valign="top" class="knowledge-profile-details__title min-height">Joined Fipra</td>
                        <td valign="top">{{ date('j F Y', strtotime($user_info->joined_fipra)) }} <br>
                            <em>
                                @if(calculate_age($user_info->joined_fipra) <= 0)
                                    Less than a year ago
                                @elseif(calculate_age($user_info->joined_fipra) == 1)
                                    1 year ago
                                @else
                                    {{ calculate_age($user_info->joined_fipra) }} years ago
                                @endif
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="knowledge-profile-details__title min-height">Total Fipra Working Time</td>
                        <td valign="top">{{ $user_info->total_fipra_working_time }}%</td>
                    </tr>
                </table>
                <br>
                <table class="knowledge-profile-details">
                    <tr>
                        <td valign="top" class="knowledge-profile-details__title">Other Networks / Memberships / Associations</td>
                    </tr>
                    <tr>
                        <td valign="top">{{ $user_info->other_network ? $user_info->other_network : 'None' }}</td>
                    </tr>
                </table>
                <br>
                <table class="knowledge-profile-details">
                    <tr>
                        <td valign="top" class="knowledge-profile-details__title">Formal Positions</td>
                    </tr>
                    <tr>
                        <td valign="top">{{ $user_info->formal_positions ? $user_info->formal_positions : 'None' }}</td>
                    </tr>
                </table>
                <br>
                <table class="knowledge-profile-details">
                    <tr>
                        <td valign="top" class="knowledge-profile-details__title">Languages</td>
                    </tr>
                    <tr>
                        <td valign="top">
                            @foreach($language_info as $name => $fluency)
                                @if($fluency)
                                    <strong>{{ $name }} <em>(fluent)</em></strong><br>
                                @else
                                    {{ $name }}<br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-7">
                @if(isset($expertise_info['areas']) && count($expertise_info['areas']) > 0)
                    <h3 class="expertise-list__section-title">Your Knowledge</h3>
                    <a href="#" class="primary knowledge-toggle"><i class="fa fa-eye"></i> Show all knowledge areas</a> <a href="#" class="primary knowledge-toggle active"><i class="fa fa-eye"></i> Show expertise only</a>
                    @foreach($expertise_info['areas'] as $group => $areas)
                        <div class="expertise-list__container">
                            <div class="expertise-list__group-title">{{ $group }}</div>
                            <table class="expertise-list" cellspacing="5" cellpadding="5" border="0" width="100%">
                                <tbody>
                                    @foreach($areas as $id => $name)
                                        {{--Use the .user-expertise class to tell if .expertise-list__container contains any user expertise
                                        If not, hide the whole container when only showing the user's expertise--}}
                                        @if(isset($score_info[$id]))
                                            <tr class="expertise-list__score-row-{{ $score_info[$id] }} @if($score_info[$id] > 3) user-expertise @endif">
                                                <td valign="middle" class="expertise-list__knowledge-area">{{ $name }}</td>
                                                <td valign="middle" class="expertise-list__score"><img class="expertise-list__score-stars" src="/img/stars-{{ $score_info[$id] }}.png" alt="{{ str_pad('', $score_info[$id], '*') }}"> {{ $score_info[$id] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

@stop