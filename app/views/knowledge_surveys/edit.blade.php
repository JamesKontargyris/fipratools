@extends('layouts.master')

@section('page-header')
    Edit your Knowledge Profile
@stop

@section('page-nav')
    <li><a href="{{ url('survey/profile') }}" class="secondary"><i class="fa fa-caret-left"></i> Back</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'POST', 'url' => 'survey/profile/edit']) }}
    <div class="row">
        <h2 class="knowledge__section-title">1. About You</h2>
        <div class="row">
            <div class="col-12">
                <div class="knowledge__section-intro">
                    {{ nl2br(get_widget('knowledge_survey_about_us_intro')) }}
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="formfield">
                    {{ Form::label('dob_day', 'Date of birth:', ['class' => 'required', 'style' => 'display:block;']) }}
                    <div class="label-info">This enables us to work out our average age profile.</div>
                    {{ Form::select('dob_day', $dob_data['days'], Input::has('date_of_birth') ? date('d', strtotime(Input::get('date_of_birth'))) : $user_info->date_of_birth != '0000-00-00' ? date('d', strtotime($user_info->date_of_birth)) : '', ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('dob_month', $dob_data['months'], Input::has('date_of_birth') ? date('m', strtotime(Input::get('date_of_birth'))) : $user_info->date_of_birth != '0000-00-00' ? date('m', strtotime($user_info->date_of_birth)) : '', ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('dob_year', $dob_data['years'], Input::has('date_of_birth') ? date('Y', strtotime(Input::get('date_of_birth'))) : $user_info->date_of_birth != '0000-00-00' ? date('Y', strtotime($user_info->date_of_birth)) : '', ['style' => 'width:auto; display:inline;']) }}
                </div>
                <div class="formfield">
                    {{ Form::label('joined_fipra_day', 'On what date did you join Fipra?', ['class' => 'required', 'style' => 'display:block;']) }}
                    {{ Form::select('joined_fipra_day', $joined_fipra_data['days'], Input::has('joined_fipra') ? date('d', strtotime(Input::get('joined_fipra'))) : $user_info->joined_fipra != '0000-00-00' ? date('d', strtotime($user_info->joined_fipra)) : '', ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('joined_fipra_month', $joined_fipra_data['months'], Input::has('joined_fipra') ? date('m', strtotime(Input::get('joined_fipra'))) : $user_info->joined_fipra != '0000-00-00' ? date('m', strtotime($user_info->joined_fipra)) : '', ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('joined_fipra_year', $joined_fipra_data['years'], Input::has('joined_fipra') ? date('Y', strtotime(Input::get('joined_fipra'))) : $user_info->joined_fipra != '0000-00-00' ? date('Y', strtotime($user_info->joined_fipra)) : '', ['style' => 'width:auto; display:inline;']) }}
                </div>
                <div class="formfield">
                    {{ Form::label('total_fipra_working_time', 'What percentage of your total working time do you spend on matters / accounts relating to Fipra?', ['class' => 'required']) }}
                    {{ Form::number('total_fipra_working_time', Input::has('total_fipra_working_time') ? Input::get('total_fipra_working_time') : isset($user_info->total_fipra_working_time) ? $user_info->total_fipra_working_time : '', ['style' => 'width:20%;', 'min' => '0', 'max' => '100']) }} <strong style="font-size:24px;">%</strong>
                </div>
            </div>
            <div class="col-6">
                <div class="formfield">
                    {{ Form::label('other_network', 'If you are personally either a) a member of one or more professional PA/PR associations, or b) a registered lobbyist, please enter details here:') }}
                    <div class="label-info">Leave blank if none.</div>
                    {{ Form::textarea('other_network', Input::has('other_network') ? Input::get('other_network') : isset($user_info->other_network) ? $user_info->other_network : '', ['rows' => '3']) }}
                </div>
                <div class="formfield">
                    {{ Form::label('formal_positions', 'What other formal positions do you hold?') }}
                    <div class="label-info"> Please list all think tanks, sports associations, company, party or government positions, or anything else where you have a formal position, whether paid or not. This does not include memberships of parties, associations or clubs - only formal positions. Leave blank if none.</div>
                    {{ Form::textarea('formal_positions', Input::has('formal_positions') ? Input::get('formal_positions') : isset($user_info->formal_positions) ? $user_info->formal_positions : '', ['rows' => '3']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="formfield">
                    {{ Form::label('languages', 'Please select the languages you speak / write:', ['class' => 'required']) }}
                    <div class="label-info">Please state all languages you speak / write, even if you only have basic notions.</div>

                    {{ Form::select("languages[]", $languages, Input::has('languages') ? Input::get('languages') : isset($language_info) ? $language_info : '', ['id' => 'language_select', 'multiple' => 'multiple']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="formfield">
                    {{ Form::label('fluent', 'Please select the languages in which you are fluent:', ['class' => 'required']) }}
                    <div class="label-info">Please select those that you both write and speak 100% fluently.</div>

                    {{ Form::select("fluent[]", $languages, Input::has('fluent') ? Input::get('fluent') : isset($fluency_info) ? $fluency_info : '', ['id' => 'fluent_select', 'multiple' => 'multiple']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="knowledge__section-title">2. Knowledge Survey</h2>
            <div class="row">
                <div class="col-12">
                    <div class="knowledge__section-intro">
                        {{ nl2br(get_widget('knowledge_survey_expertise_form_intro')) }}
                    </div>
                </div>
            </div>

            @if(isset($expertise_info['areas']) && count($expertise['areas'] > 0))
                @foreach($expertise['areas'] as $group => $areas)
                    <div class="expertise-form__container">
                        <div class="row">
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