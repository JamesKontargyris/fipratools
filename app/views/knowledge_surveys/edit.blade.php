@extends('layouts.master')

@section('page-header')
    Your Knowledge Profile
@stop

@section('page-nav')
    <li><a href="{{ route('knowledge_surveys.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Back</a></li>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            Introduction here.
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr>
        </div>
    </div>

    @include('layouts.partials.messages')

    {{ Form::open(['method' => 'POST', 'url' => '/myknowledge']) }}
    <div class="row">
        <div class="col-6">
            <div class="formfield">
                {{ Form::label('dob_day', 'Date of birth:', ['class' => 'required', 'style' => 'display:block;']) }}
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
    <div class="row">
        <div class="col-12">
            {{ Form::submit('Update my Profile', ['class' => 'primary']) }} or continue to change your expertise ratings below

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr>
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