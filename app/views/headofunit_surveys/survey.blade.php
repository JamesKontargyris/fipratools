@extends('layouts.master')

@section('page-header')
    Head of Unit Survey
    <div class="time-required"><i class="fa fa-clock-o"></i> 15-20 minutes</div>
@stop

@section('page-nav')
    @if($user->hasRole('Administrator'))<li><a href="{{ url('headofunitsurvey') }}" class="primary"><i class="fa fa-caret-left"></i> Back</a></li>@endif
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'POST', 'url' => 'headofunitsurvey/profile/edit', 'class' => 'knowledge-survey-form disable-submit-on-press-return']) }}
    {{ Form::hidden('survey_name', $survey_name) }}

    <div class="knowledge__section-intro no-bg">{{ get_widget('head_of_unit_survey_intro') }}</div>

    <div class="knowledge__section-title with-intro">People in your Unit</div>
    <p class="knowledge__section-intro">We are often asked how many people there are in the Fipra Network. This section enables us to answer that and also to understand your Unit better.</p>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_staff_public_affairs_government_relations', 'How many people in your Unit are MAINLY dedicated to the following areas:') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <table cellspacing="5" cellpadding="5" border="0" width="100%" class="survey-entry-table">
                    <thead>
                        <tr>
                            <td width="80%">Area</td>
                            <td width="20%">No. of People</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size:16px;">Public Affairs / Government Relations</td>
                            <td>{{ Form::text("unit_staff_public_affairs_government_relations", Input::has('unit_staff_public_affairs_government_relations') ? Input::get('unit_staff_public_affairs_government_relations') : isset($hou_survey_data['unit_staff_public_affairs_government_relations']) ? $hou_survey_data['unit_staff_public_affairs_government_relations'] : '', ['class' => 'numeric']) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:16px;">Other Public Relations / Media Relations</td>
                            <td>{{ Form::text("unit_staff_other_public_relations", Input::has('unit_staff_other_public_relations') ? Input::get('unit_staff_other_public_relations') : isset($hou_survey_data['unit_staff_other_public_relations']) ? $hou_survey_data['unit_staff_other_public_relations'] : '', ['class' => 'numeric']) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:16px;">Financial Public Relations</td>
                            <td>{{ Form::text("unit_staff_financial_public_relations", Input::has('unit_staff_financial_public_relations') ? Input::get('unit_staff_financial_public_relations') : isset($hou_survey_data['unit_staff_financial_public_relations']) ? $hou_survey_data['unit_staff_financial_public_relations'] : '', ['class' => 'numeric']) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:16px;">Personal and Administrative Support / Finance / Accountancy (full-time and non-fee earning)</td>
                            <td>{{ Form::text("unit_staff_personal_and_administrative_support_finance_accountancy", Input::has('unit_staff_personal_and_administrative_support_finance_accountancy') ? Input::get('unit_staff_personal_and_administrative_support_finance_accountancy') : isset($hou_survey_data['unit_staff_personal_and_administrative_support_finance_accountancy']) ? $hou_survey_data['unit_staff_personal_and_administrative_support_finance_accountancy'] : '', ['class' => 'numeric']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_staff_total', 'Total number of staff in your Unit:') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::text("unit_staff_total", Input::has('unit_staff_total') ? Input::get('unit_staff_total') : isset($hou_survey_data['unit_staff_total']) ? $hou_survey_data['unit_staff_total'] : '', ['style' => 'width:20%', 'class' => 'numeric']) }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_staff_part_time_outside_consultants', 'Does your Unit regularly use part-time staff or outside consultants in addition to those above?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('unit_staff_part_time_outside_consultants', 'Yes', Input::has('unit_staff_part_time_outside_consultants') ? Input::get('unit_staff_part_time_outside_consultants') : (isset($hou_survey_data['unit_staff_part_time_outside_consultants']) && $hou_survey_data['unit_staff_part_time_outside_consultants'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('unit_staff_part_time_outside_consultants', 'No', Input::has('unit_staff_part_time_outside_consultants') ? Input::get('unit_staff_part_time_outside_consultants') : (isset($hou_survey_data['unit_staff_part_time_outside_consultants']) && $hou_survey_data['unit_staff_part_time_outside_consultants'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad unit_staff_part_time_outside_consultants_details">
                        How many outside consultants do you <strong>regularly use</strong>?
                        <div class="label-info">We are looking for the number of people <strong>who see themselves</strong> as part of your team.</div>
                        {{ Form::text('unit_staff_part_time_outside_consultants_details', Input::has('unit_staff_part_time_outside_consultants_details') ? Input::get('unit_staff_part_time_outside_consultants_details') : isset($hou_survey_data['unit_staff_part_time_outside_consultants_details']) ? $hou_survey_data['unit_staff_part_time_outside_consultants_details'] : '', ['style' => 'width:20%', 'class' => 'numeric', 'disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_staff_positions_in_public_office', 'Do any of the persons above currently hold any positions in government or public office including regulatory and judiciary appointments?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('unit_staff_positions_in_public_office', 'Yes', Input::has('unit_staff_positions_in_public_office') ? Input::get('unit_staff_positions_in_public_office') : (isset($hou_survey_data['unit_staff_positions_in_public_office']) && $hou_survey_data['unit_staff_positions_in_public_office'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('unit_staff_positions_in_public_office', 'No', Input::has('unit_staff_positions_in_public_office') ? Input::get('unit_staff_positions_in_public_office') : (isset($hou_survey_data['unit_staff_positions_in_public_office']) && $hou_survey_data['unit_staff_positions_in_public_office'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad unit_staff_positions_in_public_office_details">
                        Please list the person(s) and let us know their current positions with appointment dates.
                        <table cellpadding="5" cellspacing="0" border="0" class="survey-entry-table unit_staff_positions_in_public_office_people">
                            <thead>
                            <tr>
                                <td width="40%"><strong>Name</strong></td>
                                <td width="30%"><strong>Position</strong></td>
                                <td width="15%"><strong>Date Appointed</strong></td>
                                <td width="5%"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!--Blank row that is inserted when the button is pressed-->
                            <tr class="entry-table-repeatable-row" style="display:none;">
                                <td>{{ Form::text("unit_staff_positions_in_public_office_people[999][name]", null, ['disabled' => 'disabled', 'class' => 'name-field']) }}</td>
                                <td>{{ Form::text("unit_staff_positions_in_public_office_people[999][position]", null, ['disabled' => 'disabled', 'class' => 'position-field']) }}</td>
                                <td>{{ Form::text("unit_staff_positions_in_public_office_people[999][from]", null, ['disabled' => 'disabled', 'class' => 'from-field']) }}</td>
                                <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                            </tr>

                            @if(Input::old('unit_staff_positions_in_public_office_people'))
                                @foreach(Input::old('unit_staff_positions_in_public_office_people') as $id => $value)
                                    <tr>
                                        <td>{{ Form::text("unit_staff_positions_in_public_office_people[$id][name]", Input::get("unit_staff_positions_in_public_office_people.$id.name")) }}</td>
                                        <td>{{ Form::text("unit_staff_positions_in_public_office_people[$id][position]", Input::get("unit_staff_positions_in_public_office_people.$id.position")) }}</td>
                                        <td>{{ Form::text("unit_staff_positions_in_public_office_people[$id][from]", Input::get("unit_staff_positions_in_public_office_people.$id.from")) }}</td>
                                        @if($id > 0) <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>@endif
                                    </tr>
                                @endforeach
                            @elseif(isset($hou_survey_data['unit_staff_positions_in_public_office_people']))
                                @foreach($hou_survey_data['unit_staff_positions_in_public_office_people'] as $id => $position_info)
                                    <tr>
                                        <td>{{ Form::text("unit_staff_positions_in_public_office_people[$id][name]", $position_info['name']) }}</td>
                                        <td>{{ Form::text("unit_staff_positions_in_public_office_people[$id][position]", $position_info['position']) }}</td>
                                        <td>{{ Form::text("unit_staff_positions_in_public_office_people[$id][from]", $position_info['from']) }}</td>
                                        @if($id > 0)
                                            <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <!--First proper row-->
                                <tr>
                                    <td>{{ Form::text("unit_staff_positions_in_public_office_people[0][name]", null, ['disabled' => 'disabled']) }}</td>
                                    <td>{{ Form::text("unit_staff_positions_in_public_office_people[0][position]", null, ['disabled' => 'disabled']) }}</td>
                                    <td>{{ Form::text("unit_staff_positions_in_public_office_people[0][from]", null, ['disabled' => 'disabled']) }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        @if(Input::old('unit_staff_positions_in_public_office_people'))
                            <a href="#" class="secondary but-small entry-table-new-row-button" data-id-index="{{ count(Input::old('unit_staff_positions_in_public_office_people')) }}" data-target-table=".unit_staff_positions_in_public_office_people">Add a row</a>
                        @elseif(isset($hou_survey_data['unit_staff_positions_in_public_office_people']))
                            <a href="#" class="secondary but-small entry-table-new-row-button" data-id-index="{{ count($hou_survey_data['unit_staff_positions_in_public_office_people']) }}" data-target-table=".unit_staff_positions_in_public_office_people">Add a row</a>
                        @else
                            <a href="#" class="secondary but-small entry-table-new-row-button" data-id-index="1" data-target-table=".unit_staff_positions_in_public_office_people">Add a row</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <div class="knowledge__section-title with-intro">Your Unit's Staff</div>
    <div class="knowledge__section-intro">
        <p>As Fipra is a public affairs brand, we only need to know in this section, more about the staff and
            consultants in your Unit that provide public affairs services.</p>
        <p>As the Network has grown significantly in recent years, not everyone knows everyone else any longer,
            and therefore we would like to make available to all, a register of all public affairs staff available in the
            Network.</p>
        <p class="no-padding">Your staff so listed will be invited to complete the Fipra Knowledge Survey (that takes only 10 minutes to
            complete) in order to have as complete a record as possible of all knowledge in the Network for the
            benefit of everyone.</p>
    </div>

    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_staff_carrying_out_public_affairs', 'Please list your full- and/or part-time staff who carry out public affairs in your Unit.') }}
                <div class="label-info">Please select their level of seniority from the dropdown list. This is helpful as we have not made much use in recent times of, for example, our combined research capability. We are trying to shine a light on opportunities also to pass more junior level work around the network which may be more efficient than recruiting new staff in some places.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <table cellpadding="5" cellspacing="0" border="0" width="100%" class="survey-entry-table unit_staff_carrying_out_public_affairs">
                    <thead>
                    <tr>
                        <td width="60%"><strong>Name</strong></td>
                        <td width="35%"><strong>Seniority</strong></td>
                        <td width="5%"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <!--Blank row that is inserted when the button is pressed-->
                    <tr class="entry-table-repeatable-row" style="display:none;">
                        <td>{{ Form::text("unit_staff_carrying_out_public_affairs[999][name]", null, ['disabled' => 'disabled', 'class' => 'name-field']) }}</td>
                        <td>{{ Form::select("unit_staff_carrying_out_public_affairs[999][seniority]", $seniority, null, ['disabled' => 'disabled', 'class' => 'seniority-field']) }}</td>
                        <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                    </tr>

                    @if(Input::old('unit_staff_carrying_out_public_affairs'))
                        @foreach(Input::old('unit_staff_carrying_out_public_affairs') as $id => $value)
                            <tr>
                                <td>{{ Form::text("unit_staff_carrying_out_public_affairs[$id][name]", Input::get("unit_staff_carrying_out_public_affairs.$id.name")) }}</td>
                                <td>{{ Form::select("unit_staff_carrying_out_public_affairs[$id][seniority]", $seniority, Input::get("unit_staff_carrying_out_public_affairs.$id.seniority")) }}</td>
                                @if($id > 0) <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>@endif
                            </tr>
                        @endforeach
                    @elseif(isset($hou_survey_data['unit_staff_carrying_out_public_affairs']))
                        @foreach($hou_survey_data['unit_staff_carrying_out_public_affairs'] as $id => $staff_member_info)
                            <tr>
                                <td>{{ Form::text("unit_staff_carrying_out_public_affairs[$id][name]", $staff_member_info['name']) }}</td>
                                <td>{{ Form::select("unit_staff_carrying_out_public_affairs[$id][seniority]", $seniority, $staff_member_info['seniority']) }}</td>
                                @if($id > 0)
                                    <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <!--First proper row-->
                        <tr>
                            <td>{{ Form::text("unit_staff_carrying_out_public_affairs[0][name]", $user->getFullName()) }}</td>
                            <td>{{ Form::select("unit_staff_carrying_out_public_affairs[0][seniority]", $seniority, null) }}</td>
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($unit_staff as $staff_member)
                            <tr>
                                <td>{{ Form::text("unit_staff_carrying_out_public_affairs[$i][name]", $staff_member->getFullName()) }}</td>
                                <td>{{ Form::select("unit_staff_carrying_out_public_affairs[$i][seniority]", $seniority, null) }}</td>
                                <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                @if(Input::old('unit_staff_carrying_out_public_affairs'))
                    <a href="#" class="primary entry-table-new-row-button" data-id-index="{{ count(Input::old('unit_staff_carrying_out_public_affairs')) }}" data-target-table=".unit_staff_carrying_out_public_affairs">Add a staff member</a>
                @elseif(isset($hou_survey_data['unit_staff_carrying_out_public_affairs']))
                    <a href="#" class="primary entry-table-new-row-button" data-id-index="{{ count($hou_survey_data['unit_staff_carrying_out_public_affairs']) }}" data-target-table=".unit_staff_carrying_out_public_affairs">Add a staff member</a>
                @else
                    <a href="#" class="primary entry-table-new-row-button" data-id-index="1" data-target-table=".unit_staff_carrying_out_public_affairs">Add a staff member</a>
                @endif
            </div>
        </div>

    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations', 'Including outside consultants you may use, how many of your total staff above have previously held public office or senior positions in trade or consumer organisations?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations', 'Less than 25%', Input::has('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations') ? Input::get('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations') : (isset($hou_survey_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations']) && $hou_survey_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations'] == 'Less than 25%') ? 1 : 0) }} Less than 25%</li>
                    <li>{{ Form::radio('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations', 'About 50%', Input::has('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations') ? Input::get('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations') : (isset($hou_survey_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations']) && $hou_survey_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations'] == 'About 50%') ? 1 : 0) }} About 50%</li>
                    <li>{{ Form::radio('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations', 'Up to 75%', Input::has('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations') ? Input::get('unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations') : (isset($hou_survey_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations']) && $hou_survey_data['unit_staff_previously_held_public_office_senior_positions_in_trade_consumer_organisations'] == 'Up to 75%') ? 1 : 0) }} Up to 75%</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="knowledge__section-title">Your Online Presence</div>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('points_of_contact', 'Who should be listed on the Network\'s website, www.fipra.com, and other internal and external marketing materials as the main points of contact for your Unit / country for both potential clients and other Fipra colleagues?') }}
                <div class="label-info">Please identify senior persons, able to take instant sales or marketing decisions on behalf of the company. All those listed should speak flawless English as this is our global business language.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <table cellpadding="5" cellspacing="0" border="0" width="100%" class="survey-entry-table points_of_contact_people">
                    <thead>
                    <tr>
                        <td width="95%"><strong>Name of Authorised Person</strong></td>
                        <td width="5%"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <!--Blank row that is inserted when the button is pressed-->
                    <tr class="entry-table-repeatable-row" style="display:none;">
                        <td>{{ Form::select("points_of_contact_people[999][name]", $unit_staff_names, null, ['disabled' => 'disabled', 'class' => 'name-field']) }}</td>
                        <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                    </tr>

                    @if(Input::old('points_of_contact_people'))
                        @foreach(Input::old('points_of_contact_people') as $id => $value)
                            <tr>
                                <td>{{ Form::select("points_of_contact_people[$id][name]", $unit_staff_names, Input::get("points_of_contact_people.$id.name")) }}</td>
                                @if($id > 0) <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>@endif
                            </tr>
                        @endforeach
                    @elseif(isset($hou_survey_data['points_of_contact_people']))
                        @foreach($hou_survey_data['points_of_contact_people'] as $id => $name)
                            <tr>
                                <td>{{ Form::select("points_of_contact_people[$id][name]", $unit_staff_names, $name) }}</td>
                                @if($id > 0)
                                    <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <!--First proper row-->
                        <tr>
                            <td>{{ Form::select("points_of_contact_people[0][name]", $unit_staff_names, null) }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                @if(Input::old('points_of_contact_people'))
                    <a href="#" class="primary entry-table-new-row-button" data-id-index="{{ count(Input::old('points_of_contact_people')) }}" data-target-table=".points_of_contact_people">Add a staff member</a>
                @elseif(isset($hou_survey_data['points_of_contact_people']))
                    <a href="#" class="primary entry-table-new-row-button" data-id-index="{{ count($hou_survey_data['points_of_contact_people']) }}" data-target-table=".points_of_contact_people">Add a staff member</a>
                @else
                    <a href="#" class="primary entry-table-new-row-button" data-id-index="1" data-target-table=".points_of_contact_people">Add a staff member</a>
                @endif
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_website_url', 'Does your Unit have a website?') }}
                <div class="label-info">Please enter it here if so.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::text('unit_website_url', Input::has('unit_website_url') ? Input::get('unit_website_url') : isset($hou_survey_data['unit_website_url']) ? $hou_survey_data['unit_website_url'] : '', ['style' => 'width:70%', 'placeholder' => 'www.websiteaddress.com', 'class' => 'url-format']) }}

                <div class="label-info" style="margin-top:15px; font-size:16px; line-height:21px;">If you do not have a website, would your Unit like help from the Network Team in setting one up? This is the first place potential clients with check you out.</div>

                <ul>
                    <li>{{ Form::radio('unit_website_help_needed', 'Yes', Input::has('unit_website_help_needed') ? Input::get('unit_website_help_needed') : (isset($hou_survey_data['unit_website_help_needed']) && $hou_survey_data['unit_website_help_needed'] == 'Yes') ? 1 : 0) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('unit_website_help_needed', 'No', Input::has('unit_website_help_needed') ? Input::get('unit_website_help_needed') : (isset($hou_survey_data['unit_website_help_needed']) && $hou_survey_data['unit_website_help_needed'] == 'No') ? 1 : 0) }} No</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('website_reciprocal_link', 'Does your website state its affiliation to the Fipra Network?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('website_state_affiliation', 'Yes', Input::has('website_state_affiliation') ? Input::get('website_state_affiliation') : (isset($hou_survey_data['website_state_affiliation']) && $hou_survey_data['website_state_affiliation'] == 'Yes') ? 1 : 0) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('website_state_affiliation', 'No', Input::has('website_state_affiliation') ? Input::get('website_state_affiliation') : (isset($hou_survey_data['website_state_affiliation']) && $hou_survey_data['website_state_affiliation'] == 'No') ? 1 : 0) }} No &nbsp;&nbsp;&nbsp;{{ Form::radio('website_state_affiliation', 'N/A', Input::has('website_state_affiliation') ? Input::get('website_state_affiliation') : (isset($hou_survey_data['website_state_affiliation']) && $hou_survey_data['website_state_affiliation'] == 'N/A') ? 1 : 0) }} N/A</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('website_reciprocal_link', 'Does your website provide a reciprocal link to www.fipra.com?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('website_reciprocal_link', 'Yes', Input::has('website_reciprocal_link') ? Input::get('website_reciprocal_link') : (isset($hou_survey_data['website_reciprocal_link']) && $hou_survey_data['website_reciprocal_link'] == 'Yes') ? 1 : 0) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('website_reciprocal_link', 'No', Input::has('website_reciprocal_link') ? Input::get('website_reciprocal_link') : (isset($hou_survey_data['website_reciprocal_link']) && $hou_survey_data['website_reciprocal_link'] == 'No') ? 1 : 0) }} No &nbsp;&nbsp;&nbsp;{{ Form::radio('website_reciprocal_link', 'N/A', Input::has('website_reciprocal_link') ? Input::get('website_reciprocal_link') : (isset($hou_survey_data['website_reciprocal_link']) && $hou_survey_data['website_reciprocal_link'] == 'N/A') ? 1 : 0) }} N/A</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('online_platform_twitter', 'Does your Unit maintain an account / page on any of the following social media / online platforms?') }}
                <div class="label-info">You may tick more than one where appropriate.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::checkbox('online_platform_twitter', '1', Input::has('online_platform_twitter') ? 1 : isset($hou_survey_data['online_platform_twitter']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Twitter</li>
                    <li class="question-details online_platform_twitter_details">
                        <div class="label-info">Please enter your Twitter URL:</div>
                        {{ Form::text('online_platform_twitter_details', Input::has('online_platform_twitter_details') ? Input::get('online_platform_twitter_details') : isset($hou_survey_data['online_platform_twitter_details']) ? $hou_survey_data['online_platform_twitter_details'] : '', ['placeholder' => 'www.twitter.com/name', 'style' => 'width:70%', 'class' => 'url-format', 'disabled' => 'disabled']) }}
                    </li>
                    <li>{{ Form::checkbox('online_platform_facebook', '1', Input::has('online_platform_facebook') ? 1 : isset($hou_survey_data['online_platform_facebook']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Facebook</li>
                    <li class="question-details online_platform_facebook_details">
                        <div class="label-info">Please enter your Facebook URL:</div>
                        {{ Form::text('online_platform_facebook_details', Input::has('online_platform_facebook_details') ? Input::get('online_platform_facebook_details') : isset($hou_survey_data['online_platform_facebook_details']) ? $hou_survey_data['online_platform_facebook_details'] : '', ['placeholder' => 'www.facebook.com/url', 'style' => 'width:70%', 'class' => 'url-format', 'disabled' => 'disabled']) }}
                    </li>
                    <li>{{ Form::checkbox('online_platform_linkedin', '1', Input::has('online_platform_linkedin') ? 1 : isset($hou_survey_data['online_platform_linkedin']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} LinkedIn</li>
                    <li class="question-details online_platform_linkedin_details">
                        <div class="label-info">Please enter your LinkedIn URL:</div>
                        {{ Form::text('online_platform_linkedin_details', Input::has('online_platform_linkedin_details') ? Input::get('online_platform_linkedin_details') : isset($hou_survey_data['online_platform_linkedin_details']) ? $hou_survey_data['online_platform_linkedin_details'] : '', ['placeholder' => 'www.linkedin.com/url', 'style' => 'width:70%', 'class' => 'url-format', 'disabled' => 'disabled']) }}
                    </li>
                    <li>{{ Form::checkbox('online_platform_youtube', '1', Input::has('online_platform_youtube') ? 1 : isset($hou_survey_data['online_platform_youtube']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} YouTube</li>
                    <li class="question-details online_platform_youtube_details">
                        <div class="label-info">Please enter your YouTube channel URL:</div>
                        {{ Form::text('online_platform_youtube_details', Input::has('online_platform_youtube_details') ? Input::get('online_platform_youtube_details') : isset($hou_survey_data['online_platform_youtube_details']) ? $hou_survey_data['online_platform_youtube_details'] : '', ['placeholder' => 'www.youtube.com/url', 'style' => 'width:70%', 'class' => 'url-format', 'disabled' => 'disabled']) }}
                    </li>
                    <li>{{ Form::checkbox('online_platform_instagram', '1', Input::has('online_platform_instagram') ? 1 : isset($hou_survey_data['online_platform_instagram']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Instagram</li>
                    <li class="question-details online_platform_instagram_details">
                        <div class="label-info">Please enter your Instagram URL:</div>
                        {{ Form::text('online_platform_instagram_details', Input::has('online_platform_instagram_details') ? Input::get('online_platform_instagram_details') : isset($hou_survey_data['online_platform_instagram_details']) ? $hou_survey_data['online_platform_instagram_details'] : '', ['placeholder' => 'www.instagram.com/url', 'style' => 'width:70%', 'class' => 'url-format', 'disabled' => 'disabled']) }}
                    </li>
                    <li>{{ Form::checkbox('online_platform_pinterest', '1', Input::has('online_platform_pinterest') ? 1 : isset($hou_survey_data['online_platform_pinterest']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Pinterest</li>
                    <li class="question-details online_platform_pinterest_details">
                        <div class="label-info">Please enter your Pinterest URL:</div>
                        {{ Form::text('online_platform_pinterest_details', Input::has('online_platform_pinterest_details') ? Input::get('online_platform_pinterest_details') : isset($hou_survey_data['online_platform_pinterest_details']) ? $hou_survey_data['online_platform_pinterest_details'] : '', ['placeholder' => 'www.pinterest.com/url', 'style' => 'width:70%', 'class' => 'url-format', 'disabled' => 'disabled']) }}
                    </li>
                    <li>{{ Form::checkbox('online_platform_other', '1', Input::has('online_platform_other') ? 1 : isset($hou_survey_data['online_platform_other']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Other</li>
                    <li class="question-details online_platform_other_details">
                        <div class="label-info">Please give further details:</div>

                        <table cellpadding="5" cellspacing="0" border="0" width="100%" class="survey-entry-table online_platform_other_details">
                            <thead>
                            <tr>
                                <td width="35%"><strong>Social Media Platform Name</strong></td>
                                <td width="60%"><strong>URL</strong></td>
                                <td width="5%"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!--Blank row that is inserted when the button is pressed-->
                            <tr class="entry-table-repeatable-row" style="display:none;">
                                <td>{{ Form::text("online_platform_other_details[999][name]", null, ['disabled' => 'disabled', 'class' => 'name-field']) }}</td>
                                <td>{{ Form::text("online_platform_other_details[999][url]", null, ['disabled' => 'disabled', 'class' => 'url-field url-format']) }}</td>
                                <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                            </tr>

                            @if(Input::old('online_platform_other_details'))
                                @foreach(Input::old('online_platform_other_details') as $id => $value)
                                    <tr>
                                        <td>{{ Form::text("online_platform_other_details[$id][name]", Input::get("online_platform_other_details.$id.name")) }}</td>
                                        <td>{{ Form::text("online_platform_other_details[$id][url]", Input::get("online_platform_other_details.$id.url"), ['class' => 'url-format']) }}</td>
                                        @if($id > 0) <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>@endif
                                    </tr>
                                @endforeach
                            @elseif(isset($hou_survey_data['online_platform_other_details']) && ! empty($hou_survey_data['online_platform_other_details']))
                                @foreach($hou_survey_data['online_platform_other_details'] as $id => $social_media_other_info)
                                    <tr>
                                        <td>{{ Form::text("online_platform_other_details[$id][name]", $social_media_other_info['name'], ['disabled' => 'disabled']) }}</td>
                                        <td>{{ Form::text("online_platform_other_details[$id][url]", $social_media_other_info['url'], ['class' => 'url-format', 'disabled' => 'disabled']) }}</td>
                                        @if($id > 0)
                                            <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <!--First proper row-->
                                <tr>
                                    <td>{{ Form::text("online_platform_other_details[0][name]", null) }}</td>
                                    <td>{{ Form::text("online_platform_other_details[0][url]", null, ['class' => 'url-format']) }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if(Input::old('online_platform_other_details'))
                            <a href="#" class="secondary but-small entry-table-new-row-button" data-id-index="{{ count(Input::old('online_platform_other_details')) }}" data-target-table=".online_platform_other_details">Add a row</a>
                        @elseif(isset($hou_survey_data['online_platform_other_details']))
                            <a href="#" class="secondary but-small entry-table-new-row-button" data-id-index="{{ count($hou_survey_data['online_platform_other_details']) }}" data-target-table=".online_platform_other_details">Add a row</a>
                        @else
                            <a href="#" class="secondary but-small entry-table-new-row-button" data-id-index="1" data-target-table=".online_platform_other_details">Add a row</a>
                        @endif


                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('online_newsletters', 'Does your Unit produce regular internal or external online newsletters?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('online_newsletters', 'Yes', Input::has('online_newsletters') ? Input::get('online_newsletters') : (isset($hou_survey_data['online_newsletters']) && $hou_survey_data['online_newsletters'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('online_newsletters', 'No', Input::has('online_newsletters') ? Input::get('online_newsletters') : (isset($hou_survey_data['online_newsletters']) && $hou_survey_data['online_newsletters'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad online_newsletters_details">
                        <div class="label-info">May the Network Team republish these in the Network Bulletin?</div>
                        {{ Form::radio('network_bulletin_can_republish', 'Yes', Input::has('network_bulletin_can_republish') ? Input::get('network_bulletin_can_republish') : (isset($hou_survey_data['network_bulletin_can_republish']) && $hou_survey_data['network_bulletin_can_republish'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('network_bulletin_can_republish', 'No', Input::has('network_bulletin_can_republish') ? Input::get('network_bulletin_can_republish') : (isset($hou_survey_data['network_bulletin_can_republish']) && $hou_survey_data['network_bulletin_can_republish'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="knowledge__section-title">Commercial Details</div>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('annual_sales_turnover', 'What was your Unit\'s annual sales / turnover in the last full calendar year (' . date('Y', strtotime('last year')) . ')?') }}
                <div class="label-info">Please state this figure as submitted in your annual returns, rounded up in Euros. It will be added up with all the others to estimate an indicative Network total turnover, as a marketing tool enabling us to better compete with large rivals who are wholly owned. <strong>It will never be used individually and will remain confidential to this survey.</strong></div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>&euro; {{ Form::text("annual_sales_turnover", Input::has('annual_sales_turnover') ? Input::get('annual_sales_turnover') : isset($hou_survey_data['annual_sales_turnover']) ? $hou_survey_data['annual_sales_turnover'] : '', ['style' => 'width:30%', 'class' => 'numeric']) }}</li>
                    <li>&nbsp;</li>
                    <li class="annual_sales_turnover_details">
                        Any further details:
                        {{ Form::textarea('annual_sales_turnover_details', Input::has('annual_sales_turnover_details') ? Input::get('annual_sales_turnover_details') : isset($hou_survey_data['annual_sales_turnover_details']) ? $hou_survey_data['annual_sales_turnover_details'] : '', ['rows' => '4']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('percentage_of_turnover_related_to_public_affairs', 'What percentage (%) of the above total turnover do you estimate relates to the Public Affairs/Government Relations part of your business?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::text("percentage_of_turnover_related_to_public_affairs", Input::has('percentage_of_turnover_related_to_public_affairs') ? Input::get('percentage_of_turnover_related_to_public_affairs') : isset($hou_survey_data['percentage_of_turnover_related_to_public_affairs']) ? $hou_survey_data['percentage_of_turnover_related_to_public_affairs'] : '', ['style' => 'width:20%', 'class' => 'numeric']) }} %
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('turnover_forecast', 'According to your forecast for the current year (' . date('Y', strtotime('this year')) . '), your Public Affairs turnover / sales will:') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('turnover_forecast', 'Rise', Input::has('turnover_forecast') ? Input::get('turnover_forecast') : (isset($hou_survey_data['turnover_forecast']) && $hou_survey_data['turnover_forecast'] == 'Rise') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Rise</li>
                    <li>{{ Form::radio('turnover_forecast', 'Remain the Same', Input::has('turnover_forecast') ? Input::get('turnover_forecast') : (isset($hou_survey_data['turnover_forecast']) && $hou_survey_data['turnover_forecast'] == 'Remain the Same') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Remain the Same</li>
                    <li>{{ Form::radio('turnover_forecast', 'Fall', Input::has('turnover_forecast') ? Input::get('turnover_forecast') : (isset($hou_survey_data['turnover_forecast']) && $hou_survey_data['turnover_forecast'] == 'Fall') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Fall</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('member_other_branded_network', 'Is your Unit a member of any other branded Public Affairs or Public Relations Network other than the Fipra Network?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('member_other_branded_network', 'Yes', Input::has('member_other_branded_network') ? Input::get('member_other_branded_network') : (isset($hou_survey_data['member_other_branded_network']) && $hou_survey_data['member_other_branded_network'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('member_other_branded_network', 'No', Input::has('member_other_branded_network') ? Input::get('member_other_branded_network') : (isset($hou_survey_data['member_other_branded_network']) && $hou_survey_data['member_other_branded_network'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad member_other_branded_network_details">
                        Please give further details:
                        {{ Form::textarea('member_other_branded_network_details', Input::has('member_other_branded_network_details') ? Input::get('member_other_branded_network_details') : isset($hou_survey_data['member_other_branded_network_details']) ? $hou_survey_data['member_other_branded_network_details'] : '', ['rows' => '4', 'disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('member_professional_association', 'Is your Unit a member of a professional association?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('member_professional_association', 'Yes', Input::has('member_professional_association') ? Input::get('member_professional_association') : (isset($hou_survey_data['member_professional_association']) && $hou_survey_data['member_professional_association'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('member_professional_association', 'No', Input::has('member_professional_association') ? Input::get('member_professional_association') : (isset($hou_survey_data['member_professional_association']) && $hou_survey_data['member_professional_association'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad member_professional_association_details">
                        Please give further details:
                        {{ Form::textarea('member_professional_association_details', Input::has('member_professional_association_details') ? Input::get('member_professional_association_details') : isset($hou_survey_data['member_professional_association_details']) ? $hou_survey_data['member_professional_association_details'] : '', ['rows' => '4', 'disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('mandatory_public_register', 'Is it mandatory in your country for your Unit or your staff to appear on a public register of public affairs professionals or lobbyists?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('mandatory_public_register', 'Yes', Input::has('mandatory_public_register') ? Input::get('mandatory_public_register') : (isset($hou_survey_data['mandatory_public_register']) && $hou_survey_data['mandatory_public_register'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('mandatory_public_register', 'No', Input::has('mandatory_public_register') ? Input::get('mandatory_public_register') : (isset($hou_survey_data['mandatory_public_register']) && $hou_survey_data['mandatory_public_register'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No &nbsp;&nbsp;&nbsp;{{ Form::radio('mandatory_public_register', 'No - but there is a voluntary register', Input::has('mandatory_public_register') ? Input::get('mandatory_public_register') : (isset($hou_survey_data['mandatory_public_register']) && $hou_survey_data['mandatory_public_register'] == 'No - but there is a voluntary register') ? 1 : 0, ['class' => 'hide-details-entry']) }} No - but there is a voluntary register</li>
                    <li class="question-details no-left-pad mandatory_public_register_details">
                        Please give further details:
                        {{ Form::textarea('mandatory_public_register_details', Input::has('mandatory_public_register_details') ? Input::get('mandatory_public_register_details') : isset($hou_survey_data['mandatory_public_register_details']) ? $hou_survey_data['mandatory_public_register_details'] : '', ['rows' => '4', 'disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('publicly_list_clients', 'Do you publicly list all or part of your public affairs / government relations clients?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('publicly_list_clients', 'Yes', Input::has('publicly_list_clients') ? Input::get('publicly_list_clients') : (isset($hou_survey_data['publicly_list_clients']) && $hou_survey_data['publicly_list_clients'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('publicly_list_clients', 'No', Input::has('publicly_list_clients') ? Input::get('publicly_list_clients') : (isset($hou_survey_data['publicly_list_clients']) && $hou_survey_data['publicly_list_clients'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad publicly_list_clients_details">
                        Please specify where you do so or on which register(s):
                        {{ Form::textarea('publicly_list_clients_details', Input::has('publicly_list_clients_details') ? Input::get('publicly_list_clients_details') : isset($hou_survey_data['publicly_list_clients_details']) ? $hou_survey_data['publicly_list_clients_details'] : '', ['rows' => '4', 'disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('work_from_other_network_in_last_12_months', 'Has your Unit taken any work from any PA/PR brand or Network other than Fipra in the last 12 months?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('work_from_other_network_in_last_12_months', 'Yes', Input::has('work_from_other_network_in_last_12_months') ? Input::get('work_from_other_network_in_last_12_months') : (isset($hou_survey_data['work_from_other_network_in_last_12_months']) && $hou_survey_data['work_from_other_network_in_last_12_months'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('work_from_other_network_in_last_12_months', 'No', Input::has('work_from_other_network_in_last_12_months') ? Input::get('work_from_other_network_in_last_12_months') : (isset($hou_survey_data['work_from_other_network_in_last_12_months']) && $hou_survey_data['work_from_other_network_in_last_12_months'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad work_from_other_network_in_last_12_months_details">
                        Please give details:
                        {{ Form::textarea('work_from_other_network_in_last_12_months_details', Input::has('work_from_other_network_in_last_12_months_details') ? Input::get('work_from_other_network_in_last_12_months_details') : isset($hou_survey_data['work_from_other_network_in_last_12_months_details']) ? $hou_survey_data['work_from_other_network_in_last_12_months_details'] : '', ['rows' => '4', 'disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="knowledge__section-title">Inter-Unit Work</div>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('most_important_trading_partner_last_calendar_year', 'Who was your most important trading partner from the Fipra Network in the last calendar year (' . date('Y', strtotime('last year')) . ')?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::text("most_important_trading_partner_last_calendar_year", Input::has('most_important_trading_partner_last_calendar_year') ? Input::get('most_important_trading_partner_last_calendar_year') : isset($hou_survey_data['most_important_trading_partner_last_calendar_year']) ? $hou_survey_data['most_important_trading_partner_last_calendar_year'] : '') }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('euros_paid_to_other_fipra_network_members_last_year', 'Approximately how much work did your Unit give in total to other Units that are also members of the Fipra Network in the last calendar year (' . date('Y', strtotime('last year')) . ')?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                &euro; {{ Form::text("euros_paid_to_other_fipra_network_members_last_year", Input::has('euros_paid_to_other_fipra_network_members_last_year') ? Input::get('euros_paid_to_other_fipra_network_members_last_year') : isset($hou_survey_data['euros_paid_to_other_fipra_network_members_last_year']) ? $hou_survey_data['euros_paid_to_other_fipra_network_members_last_year'] : '', ['style' => 'width:20%', 'class' => 'numeric']) }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('euros_received_from_other_fipra_network_members_last_year', 'Approximately how much work did your Unit receive in total from other Units that are also members of the Fipra Network in the last calendar year (' . date('Y', strtotime('last year')) . ')?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                &euro; {{ Form::text("euros_received_from_other_fipra_network_members_last_year", Input::has('euros_received_from_other_fipra_network_members_last_year') ? Input::get('euros_received_from_other_fipra_network_members_last_year') : isset($hou_survey_data['euros_received_from_other_fipra_network_members_last_year']) ? $hou_survey_data['euros_received_from_other_fipra_network_members_last_year'] : '', ['style' => 'width:20%', 'class' => 'numeric']) }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('new_clients_signed_up_last_year', 'How many new clients did your Unit sign up in the last calendar year (' . date('Y', strtotime('last year')) . ') in some way due to your involvement with the Fipra Network or any colleagues within it?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::text("new_clients_signed_up_last_year", Input::has('new_clients_signed_up_last_year') ? Input::get('new_clients_signed_up_last_year') : isset($hou_survey_data['new_clients_signed_up_last_year']) ? $hou_survey_data['new_clients_signed_up_last_year'] : '', ['style' => 'width:20%', 'class' => 'numeric']) }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('top_3_client_obtained_through_fipra_unit', 'Please think of your current top 3 clients. Is one of those clients obtained through another Fipra Unit or colleague?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('top_3_client_obtained_through_fipra_unit', 'Yes', Input::has('top_3_client_obtained_through_fipra_unit') ? Input::get('top_3_client_obtained_through_fipra_unit') : (isset($hou_survey_data['top_3_client_obtained_through_fipra_unit']) && $hou_survey_data['top_3_client_obtained_through_fipra_unit'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('top_3_client_obtained_through_fipra_unit', 'No', Input::has('top_3_client_obtained_through_fipra_unit') ? Input::get('top_3_client_obtained_through_fipra_unit') : (isset($hou_survey_data['top_3_client_obtained_through_fipra_unit']) && $hou_survey_data['top_3_client_obtained_through_fipra_unit'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('top_3_local_business_territory_competitors_1', 'Who would you name as your top 3 competitors in your territory for LOCAL business?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li style="margin-bottom:10px">
                        <strong>1</strong> {{ Form::text("top_3_local_business_territory_competitors_1", Input::has('top_3_local_business_territory_competitors_1') ? Input::get('top_3_local_business_territory_competitors_1') : isset($hou_survey_data['top_3_local_business_territory_competitors_1']) ? $hou_survey_data['top_3_local_business_territory_competitors_1'] : '', ['style' => 'width:90%']) }}
                    </li>
                    <li style="margin-bottom:10px">
                        <strong>2</strong> {{ Form::text("top_3_local_business_territory_competitors_2", Input::has('top_3_local_business_territory_competitors_2') ? Input::get('top_3_local_business_territory_competitors_2') : isset($hou_survey_data['top_3_local_business_territory_competitors_2']) ? $hou_survey_data['top_3_local_business_territory_competitors_2'] : '', ['style' => 'width:90%']) }}
                    </li>
                    <li>
                        <strong>3</strong> {{ Form::text("top_3_local_business_territory_competitors_3", Input::has('top_3_local_business_territory_competitors_3') ? Input::get('top_3_local_business_territory_competitors_3') : isset($hou_survey_data['top_3_local_business_territory_competitors_3']) ? $hou_survey_data['top_3_local_business_territory_competitors_3'] : '', ['style' => 'width:90%']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('top_3_international_business_competitors_1', 'Who would you name as your top 3 competitors for INTERNATIONAL business?') }}
                <div class="label-info">E.g. brands that would compete also with the Fipra brand.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li style="margin-bottom:10px">
                        <strong>1</strong> {{ Form::text("top_3_international_business_competitors_1", Input::has('top_3_international_business_competitors_1') ? Input::get('top_3_international_business_competitors_1') : isset($hou_survey_data['top_3_international_business_competitors_1']) ? $hou_survey_data['top_3_international_business_competitors_1'] : '', ['style' => 'width:90%']) }}
                    </li>
                    <li style="margin-bottom:10px">
                        <strong>2</strong> {{ Form::text("top_3_international_business_competitors_2", Input::has('top_3_international_business_competitors_2') ? Input::get('top_3_international_business_competitors_2') : isset($hou_survey_data['top_3_international_business_competitors_2']) ? $hou_survey_data['top_3_international_business_competitors_2'] : '', ['style' => 'width:90%']) }}
                    </li>
                    <li>
                        <strong>3</strong> {{ Form::text("top_3_international_business_competitors_3", Input::has('top_3_international_business_competitors_3') ? Input::get('top_3_international_business_competitors_3') : isset($hou_survey_data['top_3_international_business_competitors_3']) ? $hou_survey_data['top_3_international_business_competitors_3'] : '', ['style' => 'width:90%']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('unit_usp', 'What is your Unit\'s Number 1 unique selling point?') }}
                <div class="label-info">In other words, what single most important fact is different about your Unit compared to the competitors listed above? Please expand on your answer if there is more than one aspect.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::textarea("unit_usp", Input::has('unit_usp') ? Input::get('unit_usp') : isset($hou_survey_data['unit_usp']) ? $hou_survey_data['unit_usp'] : '', ['rows' => '4']) }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('fees_operation', 'Which one of these statements applies to your Unit?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('fees_operation', 'We operate almost exclusively on day rates', Input::has('fees_operation') ? Input::get('fees_operation') : (isset($hou_survey_data['fees_operation']) && $hou_survey_data['fees_operation'] == 'We operate almost exclusively on day rates') ? 1 : 0, ['class' => 'hide-details-entry']) }} We operate almost exclusively on day rates</li>
                    <li>{{ Form::radio('fees_operation', 'We operate almost exclusively on hourly rates', Input::has('fees_operation') ? Input::get('fees_operation') : (isset($hou_survey_data['fees_operation']) && $hou_survey_data['fees_operation'] == 'We operate almost exclusively on hourly rates') ? 1 : 0, ['class' => 'hide-details-entry']) }} We operate almost exclusively on hourly rates</li>
                    <li>{{ Form::radio('fees_operation', 'We operate almost exclusively on fixed retainers', Input::has('fees_operation') ? Input::get('fees_operation') : (isset($hou_survey_data['fees_operation']) && $hou_survey_data['fees_operation'] == 'We operate almost exclusively on fixed retainers') ? 1 : 0, ['class' => 'hide-details-entry']) }} We operate almost exclusively on fixed retainers</li>
                    <li>{{ Form::radio('fees_operation', 'None of the above', Input::has('fees_operation') ? Input::get('fees_operation') : (isset($hou_survey_data['fees_operation']) && $hou_survey_data['fees_operation'] == 'None of the above') ? 1 : 0, ['class' => 'reveal-details-entry']) }} None of the above</li>
                    <li class="question-details no-left-pad fees_operation_details">
                        Please give further details:
                        {{ Form::text('fees_operation_other', Input::has('fees_operation_other') ? Input::get('fees_operation_other') : isset($hou_survey_data['fees_operation_other']) ? $hou_survey_data['fees_operation_other'] : '') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('success_fees', 'Do you work with success fees?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('success_fees', 'We work with success fees', Input::has('success_fees') ? Input::get('success_fees') : (isset($hou_survey_data['success_fees']) && $hou_survey_data['success_fees'] == 'We work with success fees') ? 1 : 0, ['class' => 'hide-details-entry']) }} We work with success fees</li>
                    <li>{{ Form::radio('success_fees', 'We do not work with success fees', Input::has('success_fees') ? Input::get('success_fees') : (isset($hou_survey_data['success_fees']) && $hou_survey_data['success_fees'] == 'We do not work with success fees') ? 1 : 0, ['class' => 'hide-details-entry']) }} We do not work with success fees</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('contracts_percentage_retainers', 'What percentage of your contracts do you estimate are:') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <table cellspacing="5" cellpadding="5" border="0" class="survey-entry-table">
                    <tbody>
                    <tr>
                        <td style="font-size:16px;">Retainers:</td>
                        <td>{{ Form::text("contracts_percentage_retainers", Input::has('contracts_percentage_retainers') ? Input::get('contracts_percentage_retainers') : isset($hou_survey_data['contracts_percentage_retainers']) ? $hou_survey_data['contracts_percentage_retainers'] : '', ['class' => 'percent_100_field_1 numeric', 'style' => 'width:30%']) }} %</td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;">Time-based Fees:</td>
                        <td>{{ Form::text("contracts_percentage_time_based_fees", Input::has('contracts_percentage_time_based_fees') ? Input::get('contracts_percentage_time_based_fees') : isset($hou_survey_data['contracts_percentage_time_based_fees']) ? $hou_survey_data['contracts_percentage_time_based_fees'] : '', ['class' => 'percent_100_field_2 numeric', 'style' => 'width:30%']) }} %</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('professional_indemnity_insurance', 'Does your Unit have professional indemnity insurance?') }}
                <div class="label-info">Fipra International has professional indemnity insurance up to €5 million for any one incident which also covers those to which we subcontract.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::radio('professional_indemnity_insurance', 'Yes', Input::has('professional_indemnity_insurance') ? Input::get('professional_indemnity_insurance') : (isset($hou_survey_data['professional_indemnity_insurance']) && $hou_survey_data['professional_indemnity_insurance'] == 'Yes') ? 1 : 0, ['class' => 'reveal-details-entry']) }} Yes &nbsp;&nbsp;&nbsp;{{ Form::radio('professional_indemnity_insurance', 'No', Input::has('professional_indemnity_insurance') ? Input::get('professional_indemnity_insurance') : (isset($hou_survey_data['professional_indemnity_insurance']) && $hou_survey_data['professional_indemnity_insurance'] == 'No') ? 1 : 0, ['class' => 'hide-details-entry']) }} No</li>
                    <li class="question-details no-left-pad professional_indemnity_insurance_details">
                        Up to what amount?
                        {{ Form::text('professional_indemnity_insurance_details', Input::has('professional_indemnity_insurance_details') ? Input::get('professional_indemnity_insurance_details') : isset($hou_survey_data['professional_indemnity_insurance_details']) ? $hou_survey_data['professional_indemnity_insurance_details'] : '', ['disabled' => 'disabled']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="knowledge__section-title">Perception Audit</div>
    <div class="row">
        <div class="col-12">
            @if(isset($perception_audit) && count($perception_audit) > 0)
                @foreach($perception_audit['groups'] as $group_id => $areas)
                    <div class="expertise-form__container">
                        <div class="row no-margin">
                            <div class="col-12">
                                <label>{{ $perception_audit['questions'][$group_id] }}</label>
                            </div>
                        </div>
                        @if(isset($areas))
                            <table class="expertise-form" cellspacing="5" cellpadding="5" border="0" width="100%">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td valign="middle" class="expertise-form__score-title">1</td>
                                    <td valign="middle" class="expertise-form__score-title">2</td>
                                    <td valign="middle" class="expertise-form__score-title">3</td>
                                    <td valign="middle" class="expertise-form__score-title">4</td>
                                    <td valign="middle" class="expertise-form__score-title">5</td>
                                </tr>
                                </thead>
                                @foreach($areas as $slug => $area)
                                    <tr class="expertise-form__row">
                                        <td valign="middle" class="expertise-form__knowledge-area">{{ $area }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('perception_audit[' . $slug . ']', '1', Input::has('perception_audit[' . $slug . ']') ? Input::get('perception_audit[' . $slug . ']') : isset($hou_survey_data['perception_audit'][$slug]) && $hou_survey_data['perception_audit'][$slug] == '1' ? $hou_survey_data['perception_audit'][$slug] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('perception_audit[' . $slug . ']', '2', Input::has('perception_audit[' . $slug . ']') ? Input::get('perception_audit[' . $slug . ']') : isset($hou_survey_data['perception_audit'][$slug]) && $hou_survey_data['perception_audit'][$slug] == '2' ? $hou_survey_data['perception_audit'][$slug] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('perception_audit[' . $slug . ']', '3', Input::has('perception_audit[' . $slug . ']') ? Input::get('perception_audit[' . $slug . ']') : isset($hou_survey_data['perception_audit'][$slug]) && $hou_survey_data['perception_audit'][$slug] == '3' ? $hou_survey_data['perception_audit'][$slug] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('perception_audit[' . $slug . ']', '4', Input::has('perception_audit[' . $slug . ']') ? Input::get('perception_audit[' . $slug . ']') : isset($hou_survey_data['perception_audit'][$slug]) && $hou_survey_data['perception_audit'][$slug] == '4' ? $hou_survey_data['perception_audit'][$slug] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('perception_audit[' . $slug . ']', '5', Input::has('perception_audit[' . $slug . ']') ? Input::get('perception_audit[' . $slug . ']') : isset($hou_survey_data['perception_audit'][$slug]) && $hou_survey_data['perception_audit'][$slug] == '5' ? $hou_survey_data['perception_audit'][$slug] : '', ['class' => 'expertise-form__radio']) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('perception_audit_other_comments', 'Please give any other perception comments or criteria here.') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::textarea('perception_audit_other_comments', Input::has('perception_audit_other_comments') ? Input::get('perception_audit_other_comments') : isset($hou_survey_data['perception_audit_other_comments']) ? $hou_survey_data['perception_audit_other_comments'] : '', ['rows' => '4']) }}
            </div>
        </div>
    </div>

    <div class="knowledge__section-title">Feedback</div>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('hou_survey_feedback', 'Do you have any other strong views or opinions about the Fipra Network that you do not feel were covered by this questionnaire and that you would like to see surveyed through this system?') }}
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::textarea("hou_survey_feedback", Input::has('hou_survey_feedback') ? Input::get('hou_survey_feedback') : isset($hou_survey_data['hou_survey_feedback']) ? $hou_survey_data['hou_survey_feedback'] : '', ['rows' => 4]) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{ Form::submit('Submit Survey', ['class' => 'primary']) }}
        </div>
    </div>


    {{ Form::close() }}

@stop