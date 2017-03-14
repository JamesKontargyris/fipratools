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
                    <div class="alert alert-info with-margin-bottom">
                        <button class="close"><i class="fa fa-close"></i></button>
                        <strong>Your profile was last updated on {{ date('j F Y', strtotime($user_info->knowledge_profile_last_updated)) }}.</strong><br><br><a href="/survey/profile/edit" class="primary">Update your knowledge profile</a>
                    </div>
                </div>
            </div>
        </div>
    @elseif(! $user_info->survey_updated && $user_info->date_of_birth != '0000-00-00')
        {{--The survey_updated flag is negative but survey responses exist, so this profile must be updated--}}
        <div class="row no-margin">
            <div class="col-12">
                <div class="alert-container">
                    <div class="alert alert-warning alert-big-text with-margin-bottom">
                        <strong>Your profile is out of date and/or requires an update.</strong><br><br>
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
                    <div class="alert alert-error alert-big-text with-margin-bottom">
                        <strong>Your profile is not yet complete.</strong><br><br>
                        <a href="/survey/profile/edit" class="primary">Complete your knowledge profile</a>
                    </div>
                </div>
            </div>
        </div>

        {{ get_widget('knowledge_survey_intro') }}

    @endif

    @if($user_info->date_of_birth != '0000-00-00')
        <div class="row">
            <div class="col-7">
                <div class="border-box section-survey border-light-green">
                    <div class="knowledge-profile-section-title">Knowledge Area(s)</div>
                    <div class="border-box__content">
                        @if(isset($expertise_info['areas']) && count($expertise_info['areas']) > 0)
                            <div class="button-group">
                                <a href="#" class="primary knowledge-toggle button-show-all"><i class="fa fa-eye"></i> Show all knowledge areas</a> <a href="#" class="primary knowledge-toggle button-show-expertise"><i class="fa fa-eye"></i> Show expertise only</a>
                            </div>
                            @foreach($expertise_info['areas'] as $group => $areas)
                                <div class="expertise-list__container border-box fill section-survey">
                                    <div class="border-box__header">
                                        {{ $group }}
                                    </div>
                                    <div class="border-box__content">
                                        <table class="expertise-list" cellspacing="5" cellpadding="5" border="0" width="100%">
                                            <tbody>
                                            @foreach($areas as $id => $name)
                                                {{--Has the user registered a score for this knowledge area?--}}
                                                @if(isset($score_info[$id]))
                                                    {{--Use the .user-expertise class to tell if .expertise-list__container contains any user expertise
                                                    If not, hide the whole container when only showing the user's expertise--}}
                                                    <tr class="expertise-list__row expertise-list__score-row-{{ $score_info[$id] }} @if($score_info[$id] > 3) user-expertise @endif">
                                                        <td valign="middle" class="expertise-list__knowledge-area">{{ $name }}</td>
                                                        <td valign="middle" class="expertise-list__score">
                                                            <img class="expertise-list__score-stars" src="/img/stars-{{ $score_info[$id] }}.png" alt="{{ str_pad('', $score_info[$id], '*') }}"> {{ $score_info[$id] }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            None
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-5 last">
                <div class="row no-margin">
                    <div class="col-8">
                        <div class="border-box section-survey border-light-green">
                            <div class="knowledge-profile-section-title">Language(s)</div>
                            <div class="border-box__content">
                                <?php $languages = ''; ?>
                                @foreach($language_info as $name)
                                    <?php $languages .= $name . ', '; ?>
                                @endforeach
                                @if(isset($knowledge_data['other_languages']))
				                    <?php
				                    $other_languages = explode(',', $knowledge_data['other_languages']);
				                    foreach($other_languages as $language) $languages .= $language . ', ';
				                    ?>
                                @endif
                                {{ rtrim($languages, ', ') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-4 last">
                        <div class="border-box section-survey border-light-green">
                            <div class="knowledge-profile-section-title">Date of Birth</div>
                            <div class="border-box__content">
                                {{ date('j F Y', strtotime($user_info->date_of_birth)) }}<br>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="border-box section-survey border-light-green">
                    <div class="knowledge-profile-section-title">Your Role and Company</div>
                    <div class="border-box__content">
                        <div class="knowledge-profile-section-block">
                            <div class="knowledge-profile-section-sub-title margin-bottom">Team Membership(s)</div>
                            <?php $expertise_areas = ''; ?>
                            @foreach($knowledge_data['expertise_team'] as $id)
                            @if($id != 0)
                                <?php $expertise_areas .= \Leadofficelist\Sector_categories\Sector_category::find($id)->name . ', '; ?>
                            @else
                                <?php $expertise_areas = 'None'; ?>
                            @endif
                            @endforeach

                            <?php echo rtrim($expertise_areas, ', '); ?>
                        </div>
                        <div class="knowledge-profile-section-block">

                            <div class="knowledge-profile-section-sub-title margin-bottom">Main Function(s) in Company</div>
                            @if(isset($knowledge_data['company_function']))
                                @foreach($knowledge_data['company_function'] as $statement)
                                    {{ $statement }}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @if(isset($knowledge_data['public_office']))
                    <div class="border-box section-survey border-light-green">
                        <div class="knowledge-profile-section-title">Memberships, Associations and Positions</div>
                        <div class="border-box__content">
                            <div class="knowledge-profile-section-block">
                                <div class="knowledge-profile-section-sub-title margin-bottom">Public Office Position(s)</div>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="index-table margin-bottom">
                                    <thead>
                                    <tr>
                                        <td>Position</td>
                                        <td>From</td>
                                        <td>To</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($knowledge_data['public_office'] as $public_office)
                                        <tr>
                                            <td>{{ $public_office['position'] }}</td>
                                            <td>{{ $public_office['from'] }}</td>
                                            <td>{{ $public_office['to'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="knowledge-profile-section-block">
                                <div class="knowledge-profile-section-sub-title">Other Network(s)</div>
                                <p class="no-padding">{{ $user_info->other_network ? $user_info->other_network : 'None' }}</p>
                            </div>

                            <div class="knowledge-profile-section-block">
                                <div class="knowledge-profile-section-sub-title">Formal Position(s)</div>
                                <p class="no-padding">{{ $user_info->formal_positions ? $user_info->formal_positions : 'None' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

@stop