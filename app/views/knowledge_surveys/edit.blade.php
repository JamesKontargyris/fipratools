@extends('layouts.master')

@section('page-header')
    Edit your Knowledge Profile
@stop

@section('page-nav')
    <li><a href="{{ url('survey/profile') }}" class="primary"><i class="fa fa-caret-left"></i> Back</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'POST', 'url' => 'survey/profile/edit', 'class' => 'knowledge-survey-form']) }}

    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('dob_day', 'Date of birth:', ['class' => 'required', 'style' => 'display:block;']) }}
                <div class="label-info">This enables us to work out our average age profile and gives an idea of seniority.</div>
            </div>
        </div>
        <div class="col-7">
            <div class="formfield">
                {{ Form::select('dob_day', $dob_data['days'], Input::has('date_of_birth') ? date('d', strtotime(Input::get('date_of_birth'))) : $user_info->date_of_birth != '0000-00-00' ? date('d', strtotime($user_info->date_of_birth)) : '', ['style' => 'width:auto; display:inline;', 'class' => 'select2']) }}
                {{ Form::select('dob_month', $dob_data['months'], Input::has('date_of_birth') ? date('m', strtotime(Input::get('date_of_birth'))) : $user_info->date_of_birth != '0000-00-00' ? date('m', strtotime($user_info->date_of_birth)) : '', ['style' => 'width:auto; display:inline;', 'class' => 'select2']) }}
                {{ Form::select('dob_year', $dob_data['years'], Input::has('date_of_birth') ? date('Y', strtotime(Input::get('date_of_birth'))) : $user_info->date_of_birth != '0000-00-00' ? date('Y', strtotime($user_info->date_of_birth)) : '', ['style' => 'width:auto; display:inline;', 'class' => 'select2']) }}
            </div>
        </div>
    </div>


    <div class="knowledge__section-title">Languages</div>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('languages', 'Please select each language in which you can work. If you have just rudimentary or basic ability in a language please exclude it.', ['class' => 'required']) }}
                <div class="label-info">Click the box and select a language / languages from the drop-down menu that appears. You may also filter results by typing, e.g. rus would filter down to Russian and Belarussian.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::select("languages[]", $languages, Input::has('languages') ? Input::get('languages') : isset($language_info) ? $language_info : '', ['class' => 'select2', 'multiple' => 'multiple', 'style' => 'width:100%;']) }}
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('other_languages', 'Do you speak any other languages?') }}
                <div class="label-info">Please enter each language separated by a semi-colon(;), e.g. Tunisian; Algerian; Swahili. Each language will convert to a tag.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::text("other_languages", Input::has('other_languages') ? Input::get('other_languages') : isset($knowledge_data['other_languages']) ? $knowledge_data['other_languages'] : '', ['class' => 'tags-input']) }}
            </div>
        </div>
    </div>


    <div class="knowledge__section-title">Your Role(s)</div>

    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('expertise_team', 'Which of these teams would you place yourself in?') }}
                <div class="label-info">You may tick more than one where appropriate.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    @foreach($expertise_areas as $expertise_area_id => $expertise_area_name)
                        <li>{{ Form::checkbox('expertise_team[]', $expertise_area_id, Input::has('expertise_team[' . $expertise_area_id .']') ? Input::get('expertise_team[' . $expertise_area_id .']') : isset($knowledge_data['expertise_team']) && in_array($expertise_area_id, $knowledge_data['expertise_team']) ? 1 : 0) }} {{ $expertise_area_name }}</li>
                    @endforeach
                    <li>&nbsp;</li>
                    <li>{{ Form::checkbox('expertise_team[]', "0", Input::has('expertise_team[' . $expertise_area_id .']') ? Input::get('expertise_team[' . $expertise_area_id .']') : isset($knowledge_data['expertise_team']) && in_array(0, $knowledge_data['expertise_team']) ? 1 : 0) }} None of the above - I am into something else</li>
                </ul>
            </div>
        </div>
    </div>
    @if( ! $user->hasRole('Special Adviser'))
        <hr>
        <div class="row no-margin">
            <div class="col-5">
                <div class="formfield">
                    {{ Form::label('expertise_team', 'Please describe your main function within your company:') }}
                    <div class="label-info">You may tick more than one where appropriate.</div>
                </div>
            </div>
            <div class="col-7 last">
                <div class="formfield">
                    <ul>
                        <li>{{ Form::checkbox('company_function[]', 'I am an owner', Input::has('company_function') && in_array('I am an owner', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am an owner', $knowledge_data['company_function']) ? 1 : 0) }} I am an owner</li>

                        <li>{{ Form::checkbox('company_function[]', 'I am on the board of the company', Input::has('company_function') && in_array('I am on the board of the company', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am on the board of the company', $knowledge_data['company_function']) ? 1 : 0) }} I am on the board of the company</li>

                        <li>{{ Form::checkbox('company_function[]', 'I am in the highest tier of rates of the company', Input::has('company_function') && in_array('I am in the highest tier of rates of the company', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am in the highest tier of rates of the company', $knowledge_data['company_function']) ? 1 : 0) }} I am in the highest tier of rates of the company</li>

                        <li>{{ Form::checkbox('company_function[]', 'I am a public relations consultant', Input::has('company_function') && in_array('I am a public relations consultant', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am a public relations consultant', $knowledge_data['company_function']) ? 1 : 0) }} I am a public relations consultant</li>

                        <li>{{ Form::checkbox('company_function[]', 'I am in a supporting external role', Input::has('company_function') && in_array('I am in a supporting external role', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am in a supporting external role', $knowledge_data['company_function']) ? 1 : 0) }} I am in a supporting external role</li>

                        <li>{{ Form::checkbox('company_function[]', 'I am in a leading external role', Input::has('company_function') && in_array('I am in a leading external role', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am in a leading external role', $knowledge_data['company_function']) ? 1 : 0) }} I am in a leading external role</li>

                        <li>{{ Form::checkbox('company_function[]', 'I am in a supporting role in administration, finance or management', Input::has('company_function') && in_array('I am in a supporting role in administration, finance or management', Input::get('company_function')) ? 1 : isset($knowledge_data['company_function']) && in_array('I am in a supporting role in administration, finance or management', $knowledge_data['company_function']) ? 1 : 0) }} I am in a supporting role in administration, finance or management</li>
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <div class="row no-margin">
            <div class="col-5">
                <div class="formfield">
                    {{ Form::label('work_hours', 'Do you work full- or part-time?') }}
                </div>
            </div>
            <div class="col-7 last">
                <div class="formfield">
                    <ul>
                        <li>{{ Form::radio('work_hours', 'Full-time', Input::has('work_hours') ? Input::get('work_hours') : (isset($knowledge_data['work_hours']) && $knowledge_data['work_hours'] == 'Full-time') ? 1 : 0) }} Full-time</li>
                        <li>{{ Form::radio('work_hours', 'Part-time', Input::has('work_hours') ? Input::get('work_hours') : (isset($knowledge_data['work_hours']) && $knowledge_data['work_hours'] == 'Part-time') ? 1 : 0) }} Part-time</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <div class="knowledge__section-title">Memberships, Associations and Positions</div>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('pa_pr_organisations', 'From a marketing point of view, it may be useful for other to know if you PERSONALLY (not your company, though if your company is you may also claim this):') }}
                <div class="label-info">You may tick more than one where appropriate.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <ul>
                    <li>{{ Form::checkbox('pa_pr_organisations', '1', Input::has('pa_pr_organisations') ? 1 : isset($knowledge_data['pa_pr_organisations']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Are a member of one or more professional public affairs or public relations organisations</li>
                    <li class="question-details pa_pr_organisations_details">
                        <div class="label-info">Please give further details, separating each membership / organisation with a semi-colon (;).</div>
                        {{ Form::text('pa_pr_organisations_details', Input::has('pa_pr_organisations_details') ? Input::get('pa_pr_organisations_details') : isset($knowledge_data['pa_pr_organisations']) ? $knowledge_data['pa_pr_organisations'] : '', ['class' => 'tags-input']) }}
                    </li>

                    <li>{{ Form::checkbox('registered_lobbyist', '1', Input::has('registered_lobbyist') ? 1 : isset($knowledge_data['registered_lobbyist']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Are a registered lobbyist</li>
                    <li class="question-details registered_lobbyist_details">
                        <div class="label-info">Please give further details, separating each membership / organisation with a semi-colon (;).</div>
                        {{ Form::text('registered_lobbyist_details', Input::has('registered_lobbyist_details') ? Input::get('registered_lobbyist_details') : isset($knowledge_data['registered_lobbyist']) ? $knowledge_data['registered_lobbyist'] : '', ['class' => 'tags-input']) }}
                    </li>

                    <li>{{ Form::checkbox('formal_positions', '1', Input::has('formal_positions') ? 1 : isset($knowledge_data['formal_positions']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Have a formal title or position in any trade association, think tank, NGP, sports or professional association</li>
                    <li class="question-details formal_positions_details">
                        <div class="label-info">Please give further details, separating each membership / organisation with a semi-colon (;).</div>
                        {{ Form::text('formal_positions_details', Input::has('formal_positions_details') ? Input::get('formal_positions_details') : isset($knowledge_data['formal_positions']) ? $knowledge_data['formal_positions'] : '', ['class' => 'tags-input']) }}
                    </li>

                    <li>{{ Form::checkbox('political_party_membership', '1', Input::has('political_party_membership') ? 1 : isset($knowledge_data['political_party_membership']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Are a member of a political party</li>
                    <li class="question-details political_party_membership_details">
                        <div class="label-info">Please give further details, separating each membership with a semi-colon (;).</div>
                        {{ Form::text('political_party_membership_details', Input::has('political_party_membership_details') ? Input::get('political_party_membership_details') : isset($knowledge_data['political_party_membership']) ? $knowledge_data['political_party_membership'] : '', ['class' => 'tags-input']) }}
                    </li>

                    <li>{{ Form::checkbox('other_network', '1', Input::has('other_network') ? 1 : isset($knowledge_data['other_network']) ? 1 : 0, ['class' => 'reveal-details-entry']) }} Are a signed up member of any other network of any type</li>
                    <li class="question-details other_network_details">
                        <div class="label-info">Please give further details, separating each membership with a semi-colon (;).</div>
                        {{ Form::text('other_network_details', Input::has('other_network_details') ? Input::get('other_network_details') : isset($knowledge_data['other_network']) ? $knowledge_data['other_network'] : '', ['class' => 'tags-input']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('public_office[0][position]', 'Have you held any public office?') }}
                <div class="label-info">If so, please give details here.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <table cellpadding="5" cellspacing="0" border="0" class="survey-entry-table public-office">
                    <thead>
                    <tr>
                        <td width="45%"><strong>Position</strong></td>
                        <td width="25%"><strong>From</strong></td>
                        <td width="25%"><strong>To</strong></td>
                        <td width="5%"></td>
                    </tr>
                    </thead>
                    <tbody>
                        <!--Blank row that is inserted when the button is pressed-->
                        <tr class="entry-table-repeatable-row" style="display:none;">
                            <td>{{ Form::text("public_office[999][position]", null, ['disabled' => 'disabled', 'class' => 'position-field']) }}</td>
                            <td>{{ Form::text("public_office[999][from]", null, ['disabled' => 'disabled', 'class' => 'from-field']) }}</td>
                            <td>{{ Form::text("public_office[999][to]", null, ['disabled' => 'disabled', 'class' => 'to-field']) }}</td>
                            <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                        </tr>

                        @if(Input::has('position'))
                            @foreach(Input::get('position') as $id => $value)
                                <tr>
                                    <td>{{ Form::text("public_office[$id][position]", Input::get("public_office.$id.position")) }}</td>
                                    <td>{{ Form::text("public_office[$id][from]", Input::get("public_office.$id.from")) }}</td>
                                    <td>{{ Form::text("public_office[$id][to]", Input::get("public_office.$id.to")) }}</td>
                                    @if($id > 0) <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>@endif
                                </tr>
                            @endforeach
                        @elseif(isset($knowledge_data['public_office']))
                            @foreach($knowledge_data['public_office'] as $id => $position_info)
                                <tr>
                                    <td>{{ Form::text("public_office[$id][position]", $position_info['position']) }}</td>
                                    <td>{{ Form::text("public_office[$id][from]", $position_info['from']) }}</td>
                                    <td>{{ Form::text("public_office[$id][to]", $position_info['to']) }}</td>
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
                                <td>{{ Form::text("public_office[0][position]", null) }}</td>
                                <td>{{ Form::text("public_office[0][from]", null) }}</td>
                                <td>{{ Form::text("public_office[0][to]", null) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <a href="#" class="secondary but-small entry-table-new-row-button" data-no-of-rows="1" data-target-table=".public-office">Add a row</a>
            </div>
        </div>
    </div>
    <hr>
    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('political_party[0][position]', 'Have you held any positions in a political party (other than membership)? ') }}
                <div class="label-info">If so, please give details here.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                <table cellpadding="5" cellspacing="0" border="0" class="survey-entry-table political-party">
                    <thead>
                    <tr>
                        <td width="45%"><strong>Position</strong></td>
                        <td width="25%"><strong>Party</strong></td>
                        <td width="15%"><strong>From</strong></td>
                        <td width="15%"><strong>To</strong></td>
                        <td width="5%"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <!--Blank row that is inserted when the button is pressed-->
                    <tr class="entry-table-repeatable-row" style="display:none;">
                        <td>{{ Form::text("political_party[999][position]", null, ['disabled' => 'disabled', 'class' => 'position-field']) }}</td>
                        <td>{{ Form::text("political_party[999][party]", null, ['disabled' => 'disabled', 'class' => 'party-field']) }}</td>
                        <td>{{ Form::text("political_party[999][from]", null, ['disabled' => 'disabled', 'class' => 'from-field']) }}</td>
                        <td>{{ Form::text("political_party[999][to]", null, ['disabled' => 'disabled', 'class' => 'to-field']) }}</td>
                        <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>
                    </tr>

                    @if(Input::has('position'))
                        @foreach(Input::get('position') as $id => $value)
                            <tr>
                                <td>{{ Form::text("political_party[$id][position]", Input::get("political_party.$id.position")) }}</td>
                                <td>{{ Form::text("political_party[$id][party]", Input::get("political_party.$id.party")) }}</td>
                                <td>{{ Form::text("political_party[$id][from]", Input::get("political_party.$id.from")) }}</td>
                                <td>{{ Form::text("political_party[$id][to]", Input::get("political_party.$id.to")) }}</td>
                                @if($id > 0) <td><a href="#" class="remove-repeatable-row"><i class="fa fa-close"></i></a></td>@endif
                            </tr>
                        @endforeach
                    @elseif(isset($knowledge_data['political_party']))
                        @foreach($knowledge_data['political_party'] as $id => $position_info)
                            <tr>
                                <td>{{ Form::text("political_party[$id][position]", $position_info['position']) }}</td>
                                <td>{{ Form::text("political_party[$id][party]", $position_info['party']) }}</td>
                                <td>{{ Form::text("political_party[$id][from]", $position_info['from']) }}</td>
                                <td>{{ Form::text("political_party[$id][to]", $position_info['to']) }}</td>
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
                            <td>{{ Form::text("political_party[0][position]", null) }}</td>
                            <td>{{ Form::text("political_party[0][party]", null) }}</td>
                            <td>{{ Form::text("political_party[0][from]", null) }}</td>
                            <td>{{ Form::text("political_party[0][to]", null) }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <a href="#" class="secondary but-small entry-table-new-row-button" data-no-of-rows="1" data-target-table=".political-party">Add a row</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="knowledge__section-title">Your Knowledge</h2>

            @if(isset($expertise['areas']) && count($expertise['areas'] > 0))
                @foreach($expertise['areas'] as $group => $areas)
                    <div class="expertise-form__container">
                        <div class="row no-margin">
                            <div class="col-12">
                                <h3 class="expertise-form__group-title">{{ $group }}</h3>
                                <div class="expertise-form__group-intro">
                                    {{ nl2br(markdown_text_decode($expertise['descriptions'][$group])) }}
                                </div>
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
                                @foreach($areas as $id => $area)
                                    <tr class="expertise-form__row">
                                        <td valign="middle" class="expertise-form__knowledge-area">{{ $area }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('areas[' . $id . ']', '1', Input::has('areas[' . $id . ']') ? Input::get('areas[' . $id . ']') : isset($expertise_info[$id]) && $expertise_info[$id] == 1 ? $expertise_info[$id] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('areas[' . $id . ']', '2', Input::has('areas[' . $id . ']') ? Input::get('areas[' . $id . ']') : isset($expertise_info[$id]) && $expertise_info[$id] == 2 ? $expertise_info[$id] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('areas[' . $id . ']', '3', Input::has('areas[' . $id . ']') ? Input::get('areas[' . $id . ']') : isset($expertise_info[$id]) && $expertise_info[$id] == 3 ? $expertise_info[$id] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('areas[' . $id . ']', '4', Input::has('areas[' . $id . ']') ? Input::get('areas[' . $id . ']') : isset($expertise_info[$id]) && $expertise_info[$id] == 4 ? $expertise_info[$id] : '', ['class' => 'expertise-form__radio']) }}</td>
                                        <td valign="middle" class="expertise-form__score">{{ Form::radio('areas[' . $id . ']', '5', Input::has('areas[' . $id . ']') ? Input::get('areas[' . $id . ']') : isset($expertise_info[$id]) && $expertise_info[$id] == 5 ? $expertise_info[$id] : '', ['class' => 'expertise-form__radio']) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="row no-margin">
        <div class="col-5">
            <div class="formfield">
                {{ Form::label('additional_info', 'Finally, please let us know anything else about yourself that others in the Network should know about your knowledge, experience or ability.') }}
                <div class="label-info">This enables others in the Network to bring you into projects when the opportunity arises.</div>
            </div>
        </div>
        <div class="col-7 last">
            <div class="formfield">
                {{ Form::textarea("additional_info", Input::has('additional_info') ? Input::get('additional_info') : isset($knowledge_data['additional_info']) ? $knowledge_data['additional_info'] : '', ['rows' => '5']) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{ Form::submit('Update my Profile', ['class' => 'primary']) }}

        </div>
    </div>


    {{ Form::close() }}

    <script>
        // Make languages array available to jQuery
        var languages = [];

        @foreach($languages as $id => $name)
            languages[{{ $id }}] = '{{ $name }}';
        @endforeach
    </script>
@stop