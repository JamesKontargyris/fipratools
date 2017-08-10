@extends('layouts.survey_profile')

@section('page-nav')
@stop

@section('content')

    @include('layouts.partials.messages')

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
                @if(Leadofficelist\Knowledge_data\KnowledgeData::where('user_id', '=', $user_info->id)->where('survey_name', '=', 'head_of_unit_survey')->count() > 0) {{--Use unit_staff_total to ensure required fields are in the DB--}}
                    @if(isset($knowledge_data['unit_usp'] ))
                        <div class="row no-margin">
                            <div class="col-12">
                                <div class="border-box fill-light-green section-survey border-light-green">
                                    <div class="knowledge-profile-section-title"><i class="fa fa-trophy"></i> Our top USP</div>
                                    <div class="border-box__content no-top-pad">
                                        {{ $knowledge_data['unit_usp'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <div class="border-box fill-light-green section-survey border-light-green">
                                <div class="knowledge-profile-section-title"><i class="fa fa-users"></i> Staff @if(isset($knowledge_data['unit_staff_total']))({{ $knowledge_data['unit_staff_total'] }} in total)@endif</div>
                                <div class="border-box__content">
                                    <div class="row no-margin">
                                        <div class="col-12">
                                            @if(isset($knowledge_data['unit_staff_public_affairs_government_relations']) || isset($knowledge_data['unit_staff_financial_public_relations']) || isset($knowledge_data['unit_staff_other_public_relations']) || isset($knowledge_data['unit_staff_personal_and_administrative_support_finance_accountancy']) || isset($knowledge_data['unit_staff_part_time_outside_consultants_details']) || isset($knowledge_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations']))
                                                <div class="knowledge-profile-section-block">
                                                    <table cellpadding="0" cellspacing="0" border="0" class="index-table">
                                                        <thead>
                                                        <tr>
                                                            <td>People</td>
                                                            <td>Mainly dedicated to</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(isset($knowledge_data['unit_staff_public_affairs_government_relations']))
                                                            <tr><td valign="top"><strong>{{ $knowledge_data['unit_staff_public_affairs_government_relations'] }}</strong></td><td valign="top">Public Affairs / Government Relations</td></tr>
                                                        @endif
                                                        @if(isset($knowledge_data['unit_staff_financial_public_relations']))
                                                            <tr><td valign="top"><strong>{{ $knowledge_data['unit_staff_financial_public_relations'] }}</strong></td><td valign="top">Financial Public Relations</td></tr>
                                                        @endif
                                                        @if(isset($knowledge_data['unit_staff_other_public_relations']))
                                                            <tr><td valign="top"><strong>{{ $knowledge_data['unit_staff_other_public_relations'] }}</strong></td><td valign="top">Other Public Relations</td></tr>
                                                        @endif
                                                        @if(isset($knowledge_data['unit_staff_personal_and_administrative_support_finance_accountancy']))
                                                            <tr><td valign="top"><strong>{{ $knowledge_data['unit_staff_personal_and_administrative_support_finance_accountancy'] }}</strong></td><td valign="top">Personal and Administrative Support / Finance / Accountancy (full-time and non-fee earning)</td></tr>
                                                        @endif
                                                        @if(isset($knowledge_data['unit_staff_part_time_outside_consultants_details']))
                                                            <tr><td valign="top"><strong>{{ $knowledge_data['unit_staff_part_time_outside_consultants_details'] }}</strong></td><td valign="top">Outside consultants regularly used in any 12 month period</td></tr>
                                                        @endif
                                                        @if(isset($knowledge_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations']))
                                                            <tr><td valign="top" colspan="2"><strong>{{ $knowledge_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations'] }}</strong> of total staff have previously held public office or senior positions in trade or consumer organisations</td></tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif

                                            @if(isset($knowledge_data['unit_staff_positions_in_public_office']) && $knowledge_data['unit_staff_positions_in_public_office'] == 'Yes')
                                                <div class="knowledge-profile-section-block">
                                                    <div class="knowledge-profile-section-sub-title margin-bottom">Staff holding positions in government or public office</div>
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="index-table">
                                                        <thead>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>Position</td>
                                                            <td>Date Appointed</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($knowledge_data['unit_staff_positions_in_public_office_people'] as $id => $person_data)
                                                            <tr>
                                                                <td valign="top">{{ $person_data['name'] }}</td>
                                                                <td valign="top">{{ $person_data['position'] }}</td>
                                                                <td valign="top">{{ $person_data['from'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                            @if(isset($knowledge_data['unit_staff_carrying_out_public_affairs']))
                                                <div class="knowledge-profile-section-block">
                                                    <div class="knowledge-profile-section-sub-title margin-bottom">Full- / Part-time Staff carrying out Public Affairs</div>
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="index-table">
                                                        <thead>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>Seniority</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($knowledge_data['unit_staff_carrying_out_public_affairs'] as $id => $person_data)
                                                            <tr>
                                                                <td valign="top">{{ $person_data['name'] }}</td>
                                                                <td valign="top">{{ ucwords(str_replace('_', ' ', $person_data['seniority'])) }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                            @if(isset($knowledge_data['mandatory_public_register']))
                                                <div class="knowledge-profile-section-block">
                                                    It <strong class="green-darker text-upper">{{ ($knowledge_data['mandatory_public_register'] == 'Yes') ? 'is' : 'is not' }}</strong> mandatory in my country for staff to appear on a public register of public affairs professionals or lobbyists{{ ($knowledge_data['mandatory_public_register'] == 'No - but there is a voluntary register') ? ', but there is a voluntary register' : '' }}{{ ($knowledge_data['mandatory_public_register'] == 'Yes') ? ':<br><em>' . $knowledge_data['mandatory_public_register_details'] . '</em>' : '.'  }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-box fill-light-green section-survey border-light-green">
                                <div class="knowledge-profile-section-title"><i class="fa fa-desktop"></i> Online Presence</div>
                                <div class="border-box__content">
                                    <div class="knowledge-profile-section-block">
                                        <table cellspacing="0" cellpadding="0" border="0" class="survey-entry-table">
                                            @if(isset($knowledge_data['unit_website_url']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-globe"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['unit_website_url'] }}" target="_blank">{{ $knowledge_data['unit_website_url'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_twitter_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-twitter-square"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_twitter_details'] }}" target="_blank">{{ $knowledge_data['online_platform_twitter_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_facebook_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-facebook-square"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_facebook_details'] }}" target="_blank">{{ $knowledge_data['online_platform_facebook_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_linkedin_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-linkedin-square"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_linkedin_details'] }}" target="_blank">{{ $knowledge_data['online_platform_linkedin_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_googleplus_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-google-plus-square"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_googleplus_details'] }}" target="_blank">{{ $knowledge_data['online_platform_googleplus_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_youtube_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-youtube-square"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_youtube_details'] }}" target="_blank">{{ $knowledge_data['online_platform_youtube_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_instagram_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-instagram"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_instagram_details'] }}" target="_blank">{{ $knowledge_data['online_platform_instagram_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_pinterest_details']))
                                                <tr>
                                                    <td><i class="fa fa-lg fa-pinterest-square"></i></td>
                                                    <td style="word-break: break-all;"><strong><a href="{{ $knowledge_data['online_platform_pinterest_details'] }}" target="_blank">{{ $knowledge_data['online_platform_pinterest_details'] }}</a></strong></td>
                                                </tr>
                                            @endif
                                            @if(isset($knowledge_data['online_platform_other_details']))
                                                @foreach($knowledge_data['online_platform_other_details'] as $id => $details)
                                                    <tr>
                                                        <td>{{ $details['name'] }}</td>
                                                        <td style="word-break: break-all;"><strong><a href="{{ $details['url'] }}" target="_blank">{{ $details['url'] }}</a></strong></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="knowledge-profile-section-block">
                                        <ul class="bullets-square">
                                            @if(isset($knowledge_data['website_state_affiliation']))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['website_state_affiliation'] == 'Yes') ? 'do' : 'do not' }}</strong> state our affiliation to the Fipra Network on our website.</li>
                                            @endif
                                            @if(isset($knowledge_data['website_reciprocal_link']))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['website_reciprocal_link'] == 'Yes') ? 'do' : 'do not' }}</strong> offer a reciprocal link to fipra.com on our website.</li>
                                            @endif
                                            @if(isset($knowledge_data['online_social_media_policy']))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['online_social_media_policy'] == 'Yes') ? 'do' : 'do not' }}</strong> have an online / social media policy.</li>
                                            @endif
                                            @if(isset($knowledge_data['online_newsletters']))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['online_newsletters'] == 'Yes') ? 'do' : 'do not' }}</strong> produce regular internal or external online newsletters.</li>
                                            @endif
                                            @if(isset($knowledge_data['network_bulletin_can_republish']))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['network_bulletin_can_republish'] == 'Yes') ? 'do' : 'do not' }}</strong> give permission for our newsletter content to be re-published.</li>
                                            @endif
                                            @if(isset($knowledge_data['unit_website_help_needed']) && $user->hasRole('Administrator'))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['unit_website_help_needed'] == 'Yes') ? 'do' : 'do not' }}</strong> require website set-up assistance from the Network Team.</li>
                                            @endif
                                        </ul>
                                    </div>
                                    @if(isset($knowledge_data['points_of_contact_people']))
                                        <div class="knowledge-profile-section-block">
                                            <div class="knowledge-profile-section-sub-title margin-bottom">Online Marketing Point(s) of Contact</div>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="survey-entry-table">
                                                <tbody>
                                                    @foreach($knowledge_data['points_of_contact_people'] as $id => $person_data)
                                                        <tr>
                                                            <td valign="top"><strong>{{ $person_data['name'] }}</strong></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-4 last">
                            <div class="border-box fill-light-green section-survey border-light-green">
                                <div class="knowledge-profile-section-title"><i class="fa fa-money"></i> Fees</div>
                                <div class="border-box__content">
                                    <div class="row no-margin">
                                        <div class="knowledge-profile-section-block">
                                            <ul class="bullets-square">
                                                @if(isset($knowledge_data['fees_operation']))
                                                    <li>{{ $knowledge_data['fees_operation'] }}.</li>
                                                @endif
                                                @if(isset($knowledge_data['success_fees']))
                                                    <li>{{ $knowledge_data['success_fees'] }}.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-box fill-light-green section-survey border-light-green">
                                <div class="knowledge-profile-section-title"><i class="fa fa-info-circle"></i> Further Information</div>
                                <div class="border-box__content">
                                    <div class="row no-margin">
                                        <div class="knowledge-profile-section-block">
                                            <ul class="bullets-square">
                                                @if(isset($knowledge_data['member_other_branded_network']))
                                                    <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['member_other_branded_network'] == 'Yes') ? 'are' : 'are not' }}</strong> a member of another branded PA or PR Network(s) other than the Fipra Network{{ ($knowledge_data['member_other_branded_network'] == 'Yes') ? ':<br><em>' . $knowledge_data['member_other_branded_network_details'] . '</em>' : '.'  }}</li>
                                                @endif
                                                @if(isset($knowledge_data['member_professional_association']))
                                                    <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['member_professional_association'] == 'Yes') ? 'are' : 'are not' }}</strong> a member of a professional association{{ ($knowledge_data['member_professional_association'] == 'Yes') ? ':<br><em>' . $knowledge_data['member_professional_association_details'] . '</em>' : '.'  }}</li>
                                                @endif
                                                @if(isset($knowledge_data['publicly_list_clients']))
                                                    <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['publicly_list_clients'] == 'Yes') ? 'do' : 'do not' }}</strong> publicly list all or part of our public affairs / government relations clients{{ ($knowledge_data['publicly_list_clients'] == 'Yes') ? ':<br><em>' . $knowledge_data['publicly_list_clients_details'] . '</em>' : '.'  }}</li>
                                                @endif
                                                @if(isset($knowledge_data['work_from_other_network_in_last_12_months']))
                                                    <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['work_from_other_network_in_last_12_months'] == 'Yes') ? 'have' : 'have not' }}</strong> taken work from any PA/PR brand or Network other than Fipra in the last 12 months{{ ($knowledge_data['work_from_other_network_in_last_12_months'] == 'Yes') ? ':<br><em>' . $knowledge_data['work_from_other_network_in_last_12_months_details'] . '</em>' : '.'  }}</li>
                                                @endif
                                                @if(isset($knowledge_data['professional_indemnity_insurance']))
                                                    <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['professional_indemnity_insurance'] == 'Yes') ? 'do' : 'do not' }}</strong> have professional indemnity insurance{{ ($knowledge_data['professional_indemnity_insurance'] == 'Yes') ? ':<br><em>Up to ' . $knowledge_data['professional_indemnity_insurance_details'] . '</em>' : '.'  }}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    No information available at this time.
                @endif
            </div>
        </div>

@stop