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
            <div class="col-4">
                <div class="border-box section-survey">
                    <div class="border-box__content">
                        <div class="border-box__sub-title">Other Networks / Memberships / Associations</div>
                        <p class="no-padding">{{ $user_info->other_network ? $user_info->other_network : 'None' }}</p>
                    </div>
                </div>
                <div class="border-box section-survey">
                    <div class="border-box__content">
                        <div class="border-box__sub-title">Formal Positions</div>
                        <p class="no-padding">{{ $user_info->formal_positions ? $user_info->formal_positions : 'None' }}</p>
                    </div>
                </div>
                <div class="border-box section-survey">
                    <div class="border-box__content">
                        <div class="border-box__sub-title">Languages</div>
                        <p class="no-padding">
                            @foreach($language_info as $name)
                                {{ $name }}<br>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-8 last">
                <h3 class="expertise-list__section-title">Knowledge</h3>
                <div class="button-group">
                    <a href="#" class="primary knowledge-toggle button-show-all"><i class="fa fa-eye"></i> Show all knowledge areas</a> <a href="#" class="primary knowledge-toggle button-show-expertise"><i class="fa fa-eye"></i> Show expertise only</a>
                </div>
                @foreach($expertise_info['areas'] as $group => $areas)
                    <div class="expertise-list__container fill border-box section-survey">
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
            </div>
        </div>
    @endif

@stop