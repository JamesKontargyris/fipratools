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

                    <div class="masonry-grid">

                        <div class="masonry-grid__grid-sizer"></div>

                        @if(isset($knowledge_data['unit_usp'] ))
                            <div class="masonry-grid__item">
                                <div class="border-box fill-light-green section-survey border-light-green">
                                    <div class="knowledge-profile-section-title"><i class="fa fa-trophy"></i> Our top USP</div>
                                    <div class="border-box__content no-top-pad">
                                        {{ $knowledge_data['unit_usp'] }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="masonry-grid__item">
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

                                            <ul class="bullets-square margin-top">
                                                @if(isset($knowledge_data['unit_staff_part_time_outside_consultants_details']))
                                                    <li>We regularly use <strong class="green-darker text-upper">{{ $knowledge_data['unit_staff_part_time_outside_consultants_details'] }}</strong> outside consultants.</li>
                                                @endif

                                                @if(isset($knowledge_data['mandatory_public_register']))
                                                    <li>It <strong class="green-darker text-upper">{{ ($knowledge_data['mandatory_public_register'] == 'Yes') ? 'is' : 'is not' }}</strong> mandatory in my country for staff to appear on a public register of public affairs professionals or lobbyists{{ ($knowledge_data['mandatory_public_register'] == 'No - but there is a voluntary register') ? ', but there is a voluntary register' : '' }}{{ ($knowledge_data['mandatory_public_register'] == 'Yes') ? ':<br><em>' . $knowledge_data['mandatory_public_register_details'] . '</em>' : '.'  }}
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="masonry-grid__item">
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
                                            @if(isset($knowledge_data['unit_website_help_needed']))
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

                        <div class="masonry-grid__item">
                            <div class="border-box fill-light-green section-survey border-light-green">

                                <div class="knowledge-profile-section-title"><i class="fa fa-money"></i> Commercial Details</div>
                                <div class="border-box__content">
                                    <ul class="bullets-square">
                                        @if(isset($knowledge_data['annual_sales_turnover']))
                                            <li>
                                                Our annual sales / turnover in the last full calendar year was <strong class="green-darker text-upper">&euro;{{ number_format($knowledge_data['annual_sales_turnover']) }}</strong>.
                                                @if(isset($knowledge_data['annual_sales_turnover_details']))
                                                    <br><span class="small-print">{{ $knowledge_data['annual_sales_turnover_details'] }}</span>
                                                @endif
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['percentage_of_turnover_related_to_public_affairs']))
                                            <li>
                                                <strong class="green-darker text-upper">{{ $knowledge_data['percentage_of_turnover_related_to_public_affairs'] }}%</strong> of our turnover relates to Public Affairs / Government Relations.
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['turnover_forecast']))
                                            <li>
                                                We forecast that our Public Affairs turnover / sales will <strong class="green-darker text-upper">{{ $knowledge_data['turnover_forecast'] }}</strong> this year.
                                            </li>
                                        @endif
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

                        <div class="masonry-grid__item">
                            <div class="border-box fill-light-green section-survey border-light-green">

                                <div class="knowledge-profile-section-title"><i class="fa fa-arrows-h"></i> Inter-Unit Work</div>
                                <div class="border-box__content">
                                    <ul class="bullets-square">
                                        @if(isset($knowledge_data['most_important_trading_partner_last_calendar_year']))
                                            <li>
                                                <strong class="green-darker text-upper">{{ $knowledge_data['most_important_trading_partner_last_calendar_year'] }}</strong> was our most important trading partner in the Fipra Network last calendar year.
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['euros_paid_to_other_fipra_network_members_last_year']))
                                            <li>
                                                We gave <strong class="green-darker text-upper">&euro;{{ number_format($knowledge_data['euros_paid_to_other_fipra_network_members_last_year']) }}</strong> in work to other Fipra Network Units last calendar year.
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['euros_received_from_other_fipra_network_members_last_year']))
                                            <li>
                                                We received <strong class="green-darker text-upper">&euro;{{ number_format($knowledge_data['euros_received_from_other_fipra_network_members_last_year']) }}</strong> in work from other Fipra Network Units last calendar year.
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['new_clients_signed_up_last_year']))
                                            <li>
                                                We signed up <strong class="green-darker text-upper">{{ $knowledge_data['new_clients_signed_up_last_year'] }}</strong> new clients last calendar year.
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['top_3_client_obtained_through_fipra_unit']) && $knowledge_data['top_3_client_obtained_through_fipra_unit'] == 'Yes')
                                            <li>At least one of our top 3 clients was obtained through another Fipra Unit or colleague.</li>
                                        @endif
                                        @if(isset($knowledge_data['top_3_local_business_territory_competitors_1']) || isset($knowledge_data['top_3_local_business_territory_competitors_2']) || isset($knowledge_data['top_3_local_business_territory_competitors_3']))
                                            <li>
                                                Top local competitors:
                                                @if(isset($knowledge_data['top_3_local_business_territory_competitors_1']))
                                                    <br><strong class="green-darker">{{ $knowledge_data['top_3_local_business_territory_competitors_1'] }}</strong>
                                                @endif
                                                @if(isset($knowledge_data['top_3_local_business_territory_competitors_2']))
                                                    <br><strong class="green-darker">{{ $knowledge_data['top_3_local_business_territory_competitors_2'] }}</strong>
                                                @endif
                                                @if(isset($knowledge_data['top_3_local_business_territory_competitors_3']))
                                                    <br><strong class="green-darker">{{ $knowledge_data['top_3_local_business_territory_competitors_3'] }}</strong>
                                                @endif
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['top_3_international_business_competitors_1']) || isset($knowledge_data['top_3_international_business_competitors_2']) || isset($knowledge_data['top_3_international_business_competitors_3']))
                                            <li>
                                                Top international competitors:
                                                @if(isset($knowledge_data['top_3_international_business_competitors_1']))
                                                    <br><strong class="green-darker">{{ $knowledge_data['top_3_international_business_competitors_1'] }}</strong>
                                                @endif
                                                @if(isset($knowledge_data['top_3_international_business_competitors_2']))
                                                    <br><strong class="green-darker">{{ $knowledge_data['top_3_international_business_competitors_2'] }}</strong>
                                                @endif
                                                @if(isset($knowledge_data['top_3_international_business_competitors_3']))
                                                    <br><strong class="green-darker">{{ $knowledge_data['top_3_international_business_competitors_3'] }}</strong>
                                                @endif
                                            </li>
                                        @endif
                                        @if(isset($knowledge_data['contracts_percentage_retainers']) && isset($knowledge_data['contracts_percentage_time_based_fees']))
                                            <li>
                                                We estimate that our contracts are:
                                                <br><strong class="green-darker">{{ $knowledge_data['contracts_percentage_retainers'] }}%</strong> retainers
                                                <br><strong class="green-darker">{{ $knowledge_data['contracts_percentage_time_based_fees'] }}%</strong> time-based fees
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                            </div>
                        </div>

                        <div class="masonry-grid__item">
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
                                                @if(isset($knowledge_data['hou_survey_feedback']))
                                                    <li>Survey feedback: <span class="small-print">{{ $knowledge_data['hou_survey_feedback'] }}</span></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="masonry-grid__item">
                            <div class="border-box fill-light-green section-survey border-light-green">

                                <div class="knowledge-profile-section-title"><i class="fa fa-eye"></i> Perception Audit</div>
                                <div class="border-box__content">

                                    @if(isset($perception_audit) && count($perception_audit > 0))
                                        @foreach($perception_audit['groups'] as $group_id => $areas)
                                            <div class="knowledge-profile-section-block">
                                                <div class="knowledge-profile-section-sub-title margin-bottom">{{ $perception_audit['questions'][$group_id] }}</div>
                                                @if(isset($areas))
                                                    <table class="index-table" cellspacing="5" cellpadding="5" border="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <td></td>
                                                            <td valign="middle" style="text-align: center">1</td>
                                                            <td valign="middle" style="text-align: center">2</td>
                                                            <td valign="middle" style="text-align: center">3</td>
                                                            <td valign="middle" style="text-align: center">4</td>
                                                            <td valign="middle" style="text-align: center">5</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($areas as $slug => $area)
                                                                @if(isset($knowledge_data['perception_audit'][$slug]))
                                                                    <tr>
                                                                        <td valign="middle">{{ $area }}</td>
                                                                        @if($knowledge_data['perception_audit'][$slug] == 1)
                                                                            <td style="text-align:center"><i class="fa fa-circle text--green"></i></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        @elseif($knowledge_data['perception_audit'][$slug] == 2)
                                                                            <td></td>
                                                                            <td style="text-align:center"><i class="fa fa-circle text--green"></i></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        @elseif($knowledge_data['perception_audit'][$slug] == 3)
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td style="text-align:center"><i class="fa fa-circle text--green"></i></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        @elseif($knowledge_data['perception_audit'][$slug] == 4)
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td style="text-align:center"><i class="fa fa-circle text--green"></i></td>
                                                                            <td></td>
                                                                        @elseif($knowledge_data['perception_audit'][$slug] == 5)
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td style="text-align:center"><i class="fa fa-circle text--green"></i></td>
                                                                        @endif
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif

                                    @if(isset($knowledge_data['perception_audit_other_comments']))
                                        <div class="knowledge-profile-section-block">
                                            Perception comments and other criteria: <span class="small-print">{{ $knowledge_data['perception_audit_other_comments'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div> {{--/.masonry-grid--}}

                @else
                    No information available at this time.
                @endif

            </div>
        </div>
    </div>

    <div class="modal bio-modal">
        <h3>{{ $user_info->first_name }} {{ $user_info->last_name }}</h3>
        @if(isset($fipriot_info->bio) && $fipriot_info->bio != '')
            {{ nl2br($fipriot_info->bio) }}
        @endif
    </div>

@stop