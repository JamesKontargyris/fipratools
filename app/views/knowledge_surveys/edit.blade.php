@extends('layouts.master')

@section('page-header')
    Your Knowledge Profile
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_surveys.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Back</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'POST', 'url' => '/myknowledge']) }}
    <div class="row">
        <h2 class="knowledge__section-title">1. About You</h2>
        <div class="row">
            <div class="col-12">
                <div class="knowledge__section-intro">Introduction here.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="formfield">
                    {{ Form::label('dob_day', 'Date of birth:', ['class' => 'required', 'style' => 'display:block;']) }}
                    <div class="label-info">This enables us to work out our average age profile.</div>
                    {{ Form::select('dob_day', $dob_data['days'], null, ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('dob_month', $dob_data['months'], null, ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('dob_year', $dob_data['years'], null, ['style' => 'width:auto; display:inline;']) }}
                </div>
                <div class="formfield">
                    {{ Form::label('joined_fipra_day', 'On what date did you join Fipra?', ['class' => 'required', 'style' => 'display:block;']) }}
                    {{ Form::select('joined_fipra_day', $joined_fipra_data['days'], null, ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('joined_fipra_month', $joined_fipra_data['months'], null, ['style' => 'width:auto; display:inline;']) }}
                    {{ Form::select('joined_fipra_year', $joined_fipra_data['years'], null, ['style' => 'width:auto; display:inline;']) }}
                </div>
                <div class="formfield">
                    {{ Form::label('total_fipra_working_time', 'What percentage of your total working time do you spend on matters / accounts relating to Fipra?', ['class' => 'required']) }}
                    {{ Form::text('total_fipra_working_time', null, ['style' => 'width:20%;']) }} <strong style="font-size:24px;">%</strong>
                </div>
                <div class="formfield">
                    {{ Form::label('languages', 'Please select the languages you speak / write:', ['class' => 'required']) }}
                    <div class="label-info">Please state all languages, even if you only have basic notions, and state all of them in general order of ability.</div>

                    {{ Form::select("languages[]", $languages, null, ['id' => 'language_select', 'multiple' => 'multiple']) }}

                </div>
                <div class="formfield">
                    {{ Form::label('fluent', 'Please select the languages in which you are fluent:') }}
                    <div class="label-info">Please select those you speak and write like a native (i.e. 100% fluently both written and spoken).</div>

                    <div class="fluent-languages">
                        <div class="fluent-language-row master">
                            {{ Form::checkbox('fluent_') }} <span class="fluent-language-name">Language Name</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-6">
                <div class="formfield">
                    {{ Form::label('other_network', 'If you are personally either a) a member of one or more professional PA/PR associations, or b) a registered lobbyist, please enter details here:') }}
                    {{ Form::textarea('other_network') }}
                </div>
                <div class="formfield">
                    {{ Form::label('formal_positions', 'What other formal positions do you hold?') }}
                    <div class="label-info"> Please list all think tanks, sports associations, company, party or government positions, or anything else where you have a formal position, whether paid or not. This does not include memberships of parties, associations or clubs - only formal positions.</div>
                    {{ Form::textarea('formal_positions') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="knowledge__section-title">2. Knowledge Survey</h2>
            <div class="row">
                <div class="col-12">
                    <p class="knowledge__section-intro">The results from this section will be made available in detail in a table to the whole Network. It will help the whole network identify where knowledge and experience lies that may usefully be brought into existing and future client relationships.</p>
                </div>
            </div>

            @foreach($expertise as $group => $areas)
                <div class="expertise-form__container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="expertise-form__group-title">{{ $group }}</h3>
                            Introduction here.
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
                                    <td valign="middle" class="expertise-form__score">{{ Form::radio('area[' . $id . ']', '1', null, ['class' => 'expertise-form__radio']) }}</td>
                                    <td valign="middle" class="expertise-form__score">{{ Form::radio('area[' . $id . ']', '2', null, ['class' => 'expertise-form__radio']) }}</td>
                                    <td valign="middle" class="expertise-form__score">{{ Form::radio('area[' . $id . ']', '3', null, ['class' => 'expertise-form__radio']) }}</td>
                                    <td valign="middle" class="expertise-form__score">{{ Form::radio('area[' . $id . ']', '4', null, ['class' => 'expertise-form__radio']) }}</td>
                                    <td valign="middle" class="expertise-form__score">{{ Form::radio('area[' . $id . ']', '5', null, ['class' => 'expertise-form__radio']) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            @endforeach
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