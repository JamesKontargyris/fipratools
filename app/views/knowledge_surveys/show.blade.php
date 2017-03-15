@extends('layouts.survey_profile')

@section('content')

    @include('layouts.partials.messages')

    @if($user_info->date_of_birth != '0000-00-00')
        <div class="row">
            @if(isset($fipriot_info->email))
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
                                    <div class="fipriot-info__bio-excerpt">{{ preg_replace('/(.*?[?!.](?=\s|$)).*/', '\\1', $fipriot_info->bio) }}</div>
                                    <a href="#" class="modal-open fipriot-info__read-more-link" data-modal="bio-modal">Read more</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(isset($fipriot_info->email))
                <div class="col-10 last">
            @else
                <div class="col-12">
            @endif
                <div id="page-header" class="section-survey">
                    <h2 class="no-right-pad">@if(isset($fipriot_info->photo)) <img src="{{ $fipriot_info->photo }}" alt="{{ $fipriot_info->name }}" class="fipriot-info__page-header-photo">@endif <strong>{{ $user_info->first_name }} {{ $user_info->last_name }}</strong><br><span style="padding-top:10px; font-size:16px"> @if($user_info->hasRole('Special Adviser'))Special Adviser @else {{ $user_info->unit()->pluck('name') }} @endif</span></h2>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="border-box section-survey border-light-green">
                            <div class="knowledge-profile-section-title">Knowledge Areas</div>
                            <div class="border-box__content">
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

                        @if(isset($knowledge_data['additional_info']))
                            <div class="border-box section-survey border-light-green">
                                <div class="knowledge-profile-section-title">Additional Information</div>
                                <div class="border-box__content">
                                    {{ nl2br($knowledge_data['additional_info']) }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-5 last">
                        <div class="border-box section-survey border-light-green">
                            <div class="knowledge-profile-section-title">Age</div>
                            <div class="border-box__content">
                                {{ calculate_age($user_info->date_of_birth) }} years old<br>
                            </div>
                        </div>
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

                        @if(isset($knowledge_data['expertise_team']) || isset($knowledge_data['company_function']) || isset($knowledge_data['work_hours']))
                            <div class="border-box section-survey border-light-green">
                                <div class="knowledge-profile-section-title">Role(s)</div>
                                <div class="border-box__content">
                                    @if(isset($knowledge_data['expertise_team']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title margin-bottom">Team(s)</div>
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
                                    @endif

                                    @if(isset($knowledge_data['company_function']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title margin-bottom">Main Function(s) in Company</div>
                                            @if(isset($knowledge_data['company_function']))
                                                @foreach($knowledge_data['company_function'] as $statement)
                                                    {{ $statement }}<br>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif

                                    @if(isset($knowledge_data['work_hours']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title margin-bottom">Working Hours</div>
                                            {{ $knowledge_data['work_hours'] }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(isset($knowledge_data['pa_pr_organisations']) || isset($knowledge_data['registered_lobbyist']) || isset($knowledge_data['formal_positions']) || isset($knowledge_data['political_party_membership']) || isset($knowledge_data['other_network']) || isset($knowledge_data['public_office']) || isset($knowledge_data['political_party']))

                            <div class="border-box section-survey border-light-green">
                                <div class="knowledge-profile-section-title">Memberships, Associations and Positions</div>
                                <div class="border-box__content">

                                    @if(isset($knowledge_data['pa_pr_organisations']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title">PA / PR Organisation Memberships</div>
                                            <p class="no-padding">{{ str_replace(';','<br>',$knowledge_data['pa_pr_organisations']) }}</p>
                                        </div>
                                    @endif

                                    @if(isset($knowledge_data['registered_lobbyist']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title">Lobbyist Registrations</div>
                                            <p class="no-padding">{{ str_replace(';','<br>',$knowledge_data['registered_lobbyist']) }}</p>
                                        </div>
                                    @endif

                                    @if(isset($knowledge_data['formal_positions']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title">Formal titles / positions</div>
                                            <p class="no-padding">{{ str_replace(';','<br>',$knowledge_data['formal_positions']) }}</p>
                                        </div>
                                    @endif

                                    @if(isset($knowledge_data['political_party_membership']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title">Political Party Membership</div>
                                            <p class="no-padding">{{ str_replace(';','<br>',$knowledge_data['political_party_membership']) }}</p>
                                        </div>
                                    @endif

                                    @if(isset($knowledge_data['other_network']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title">Network Memberships</div>
                                            <p class="no-padding">{{ str_replace(';','<br>',$knowledge_data['other_network']) }}</p>
                                        </div>
                                    @endif

                                    @if(isset($knowledge_data['public_office']))
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
                                    @endif

                                    @if(isset($knowledge_data['political_party']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title margin-bottom">Political Party Position(s)</div>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="index-table margin-bottom">
                                                <thead>
                                                <tr>
                                                    <td>Position</td>
                                                    <td>Party</td>
                                                    <td>From</td>
                                                    <td>To</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($knowledge_data['political_party'] as $political_party)
                                                    <tr>
                                                        <td>{{ $political_party['position'] }}</td>
                                                        <td>{{ $political_party['party'] }}</td>
                                                        <td>{{ $political_party['from'] }}</td>
                                                        <td>{{ $political_party['to'] }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="modal bio-modal">
            <h3>{{ $user_info->first_name }} {{ $user_info->last_name }}</h3>
            @if(isset($fipriot_info->bio) && $fipriot_info->bio != '')
                {{ nl2br($fipriot_info->bio) }}
            @endif
        </div>
    @endif

@stop