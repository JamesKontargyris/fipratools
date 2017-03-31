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
                <div class="border-box section-survey fill-light-green border-light-green">
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

                @if(isset($knowledge_data['additional_info']))
                    <div class="border-box section-survey fill-light-green border-light-green">
                        <div class="knowledge-profile-section-title">Additional Information</div>
                        <div class="border-box__content no-top-pad">
                            {{ nl2br($knowledge_data['additional_info']) }}
                        </div>
                    </div>
                @endif

            </div>

            <div class="col-5 last">
                <div class="row no-margin">
                    <div class="col-8">
                        <div class="border-box section-survey fill-light-green border-light-green">
                            <div class="knowledge-profile-section-title">Language(s)</div>
                            <div class="border-box__content no-top-pad">
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
                        <div class="border-box section-survey fill-light-green border-light-green">
                            <div class="knowledge-profile-section-title">Date of Birth</div>
                            <div class="border-box__content no-top-pad">
                                {{ date('j M y', strtotime($user_info->date_of_birth)) }} ({{ calculate_age($user_info->date_of_birth) }} years)<br>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="border-box section-survey fill-light-green border-light-green">
                    <div class="knowledge-profile-section-title">Your Roles</div>
                    <div class="border-box__content">
                        @if(isset($knowledge_data['expertise_team']))
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
                        @endif

                        @if(isset($knowledge_data['company_function']))
                            <div class="knowledge-profile-section-block">
                                <div class="knowledge-profile-section-sub-title margin-bottom">Main Function(s) in Company</div>
                                    @foreach($knowledge_data['company_function'] as $statement)
                                        {{ $statement }}<br>
                                    @endforeach
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


                @if(isset($knowledge_data['pa_pr_organisations']) || isset($knowledge_data['registered_lobbyist']) || isset($knowledge_data['formal_positions']) || isset($knowledge_data['political_party_membership']) || isset($knowledge_data['other_network']) || isset($knowledge_data['public_office']) || isset($knowledge_data['political_party']))
                    <div class="border-box section-survey fill-light-green border-light-green">
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
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if($user->hasRole('Head of Unit') && isset($knowledge_data['unit_staff_total'])) {{--Use unit_staff_total to ensure required fields are in the DB--}}
                    {{--User viewing is a Head of Unit, so show Unit Information from Head of Unit Survey--}}
                    <div class="knowledge__section-title with-margin-bottom">Unit Information</div>
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
                    <div class="row">
                        <div class="col-4">
                            <div class="border-box fill-light-green section-survey border-light-green">
                                <div class="knowledge-profile-section-title"><i class="fa fa-users"></i> Staff ({{ $knowledge_data['unit_staff_total'] }} in total)</div>
                                <div class="border-box__content">
                                    <div class="row no-margin">
                                        <div class="col-12">
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

                                            @if($knowledge_data['unit_staff_positions_in_public_office'] == 'Yes')
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
                                                    <td><i class="fa fa-facebook-square"></i></td>
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
                                        </table>
                                    </div>
                                    <div class="knowledge-profile-section-block">
                                        <ul class="bullets-square">
                                            @if(isset($knowledge_data['website_reciprocal_link']))
                                                <li>We <strong class="green-darker text-upper">{{ ($knowledge_data['website_reciprocal_link'] == 'Yes') ? 'do' : 'do not' }}</strong> state our affiliation to the Fipra Network on our website.</li>
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
                                                <tr>
                                                    <td>{{ $knowledge_data['points_of_contact'] }}:</td>
                                                </tr>
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
                                                @if(isset($knowledge_data['fees_operation']))
                                                    <li>{{ $knowledge_data['fees_operation'] }}.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($user_info->survey_updated)
            {{--Profile is up to date--}}
            <div class="row">
                <div class="col-12">
                    <a href="/survey/profile/edit" class="primary">Update your knowledge profile</a>
                </div>
            </div>
        @elseif(! $user_info->survey_updated && $user_info->date_of_birth != '0000-00-00')
            {{--The survey_updated flag is negative but survey responses exist, so this profile must be updated--}}
            <div class="row no-margin">
                <div class="col-12">
                    <a href="/survey/profile/edit" class="primary">Update your knowledge profile</a>
                </div>
            </div>
        @endif

    @endif

@stop