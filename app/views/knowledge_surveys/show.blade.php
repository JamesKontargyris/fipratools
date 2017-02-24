@extends('layouts.master')

@section('page-header')
    {{ $user_info->getFullName() }}'s Knowledge Profile
@stop

@section('page-nav')
    <li><a href="{{ URL::previous() }}" class="secondary"><i class="fa fa-caret-left"></i> Back</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    @if($user_info->date_of_birth != '0000-00-00')
        <div class="row">
            <div class="col-5">
                <table class="knowledge-profile-details">
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
                <h3 class="expertise-list__section-title">Knowledge</h3>
                <a href="#" class="primary knowledge-toggle"><i class="fa fa-eye"></i> Show all knowledge areas</a> <a href="#" class="primary knowledge-toggle active"><i class="fa fa-eye"></i> Show expertise only</a>
                @foreach($expertise_info['areas'] as $group => $areas)
                    <div class="expertise-list__container">
                        <div class="expertise-list__group-title">{{ $group }}</div>
                        <table class="expertise-list" cellspacing="5" cellpadding="5" border="0" width="100%">
                            <tbody>
                            @foreach($areas as $id => $name)
                                {{--Use the .user-expertise class to tell if .expertise-list__container contains any user expertise
                                If not, hide the whole container when only showing the user's expertise--}}
                                <tr class="expertise-list__score-row-{{ isset($score_info[$id]) ? $score_info[$id] : '' }} @if(isset($score_info[$id]) && $score_info[$id] > 3) user-expertise @endif">
                                    <td valign="middle" class="expertise-list__knowledge-area">{{ $name }}</td>
                                    <td valign="middle" class="expertise-list__score">
                                        @if(isset($score_info[$id]))
                                            <img class="expertise-list__score-stars" src="/img/stars-{{ $score_info[$id] }}.png" alt="{{ str_pad('', $score_info[$id], '*') }}"> {{ $score_info[$id] }}
                                        @else
                                            No score registered
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@stop