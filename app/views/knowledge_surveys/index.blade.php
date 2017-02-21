@extends('layouts.list')

@section('page-header')
    @if(is_filter($items->key))
        <i class="fa fa-filter"></i> Filtering on: {{ $items->filter_value }}

    @elseif(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('survey.SearchType') ? Session::get('survey.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Knowledge Profiles
    @endif
@stop

@section('page-nav')
    <li><a href="{{ url('/survey/profile/edit') }}" class="secondary"><i class="fa fa-plus-circle"></i> Update your Knowledge Profile</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')

    @if(isset($user_info) && ! $user_info->survey_updated && $user_info->date_of_birth != '0000-00-00')
        {{--The survey_updated flag is negative but survey responses exist, so this profile must be updated--}}
        <div class="row no-margin">
            <div class="col-12">
                <div class="alert-container">
                    <div class="alert alert-warning alert-big-text">
                        <strong>Your profile is out of date and/or requires an update.</strong><br>
                        <a href="/survey/profile/edit" class="primary">Update your knowledge profile</a>
                    </div>
                </div>
            </div>
        </div>
    @elseif(isset($user_info) && ! $user_info->survey_updated && $user_info->date_of_birth == '0000-00-00')
        {{--Otherwise, the profile does not yet exist and needs to be completed--}}
        <div class="row">
            <div class="col-12">
                <div class="alert-container">
                    <div class="alert alert-error alert-big-text">
                        <strong>Your knowledge profile needs to be completed.</strong><br>
                        <a href="/survey/profile/edit" class="primary">Continue</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(count($items) > 0)

        @if(get_widget('knowledge_survey_details'))
            <div class="row">
                <div class="col-12">
                    {{ nl2br(get_widget('knowledge_survey_details')) }}
                </div>
            </div>
        @endif

        @include('layouts.partials.rows_nav')

        @include('layouts.partials.filters')

        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                        <tr>
                            <td width="20%">Name</td>
                            <td width="20%">Unit</td>
                            <td width="35%">Expertise</td>
                            <td width="20%" class="hide-s">Languages</td>
                            <td width="5%" class="hide-print hide-s"></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $profile)
                            <?php
                                    /*Get user expertise with a score of 4 or 5*/
                                $user_expertise = $profile->knowledge_areas()->where('score', '=', 4)->orWhere('score', '=', 5)->get()->lists('name');
                                /* Get user language(s) and fluency data*/
	                            $user_languages = [];
                                $languages = $profile->knowledge_languages()->get()->toArray();
	                            foreach($languages as $language) {
	                            	$user_languages[] = $language['pivot']['fluent'] ? '<strong>' . $language['name'] . ' (fluent)</strong>' : $language['name'];
                                }
                            ?>
                            <tr>
                                <td><a href="{{ route('survey.show', $profile->id) }}"><strong>{{ $profile->getFullName() }}</strong></a></td>
                                <td><a href="{{ route('units.show', $profile->unit()->first()->id) }}">{{ $profile->unit()->first()->name }}</a></td>
                                <td>{{ implode($user_expertise, ', ') }}</td>
                                <td class="hide-s">{{ implode($user_languages, ', ') }}</td>
                                <td class="hide-print hide-s"><strong><a href="{{ route('survey.show', ['id' => $profile->id]) }}"> Profile</a></strong></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        @include('layouts.partials.pagination_container')
    @else
        @include('layouts.partials.index_no_records_found')
    @endif
@stop
