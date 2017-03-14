@extends('layouts.survey_profile')

@section('content')

    @include('layouts.partials.messages')

    @if($user_info->date_of_birth != '0000-00-00')
        <div class="row">
            <div class="col-2 hide-s">
                <div class="fipriot-info">
                    @if(isset($fipriot_info->photo)) <img src="{{ $fipriot_info->photo }}" alt="{{ $fipriot_info->name }}" class="fipriot-info__photo" style="border-radius:5px; background:radial-gradient(white 60%, #efefef 100%); max-width:100%">@endif

                    @if(isset($fipriot_info->email) || isset($fipriot_info->tel) || isset($fipriot_info->fax) || isset($fipriot_info->address))
                        <div class="fipriot-info__group">
                            <div class="fipriot-info__group-title">
                                Contact details
                            </div>
                            <div class="fipriot-info__group-content">
                                @if(isset($fipriot_info->email) && $fipriot_info->email != '')
                                    <div class="fipriot-info__group-row"><a href="mailto:{{$fipriot_info->email}}">{{ $fipriot_info->email }}</a></div>
                                @endif
                                @if(isset($fipriot_info->tel) && $fipriot_info->tel != '')
                                    <div class="fipriot-info__group-row">Tel: {{ $fipriot_info->tel }}</div>
                                @endif
                                @if(isset($fipriot_info->fax) && $fipriot_info->fax != '')
                                    <div class="fipriot-info__group-row">Fax: {{ $fipriot_info->fax }}</div>
                                @endif
                                @if(isset($fipriot_info->address) && $fipriot_info->address != '')
                                    <div class="fipriot-info__group-row">{{ nl2br($fipriot_info->address) }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(isset($fipriot_info->bio) && $fipriot_info->bio != '')
                        <div class="fipriot-info__group">
                            <div class="fipriot-info__group-title">
                                Bio
                            </div>
                            <div class="fipriot-info__group-content">
                                <div class="fipriot-info__bio-excerpt showjs">{{ preg_replace('/(.*?[?!.](?=\s|$)).*/', '\\1', $fipriot_info->bio) }}</div>
                                <div class="fipriot-info__bio hidejs">{{ nl2br($fipriot_info->bio) }}</div>
                                <a href="#" class="fipriot-info__read-more-link showjs">Read more</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-10">
                <div id="page-header" class="section-survey">
                    <h2 class="no-right-pad">@if(isset($fipriot_info->photo)) <img src="{{ $fipriot_info->photo }}" alt="{{ $fipriot_info->name }}" class="fipriot-info__page-header-photo">@endif <strong>{{ $user_info->first_name }} {{ $user_info->last_name }}</strong><br><span style="padding-top:10px; font-size:16px"> @if($user_info->hasRole('Special Adviser'))Special Adviser @else {{ $user_info->unit()->pluck('name') }} @endif</span></h2>
                </div>
                <div class="row">
                    <div class="col-6">
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
                    <div class="col-6 last">
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
                </div>
            </div>
        </div>

    @endif

@stop