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
    <li><a href="{{ url('/survey/profile/edit') }}" class="secondary"><i class="fa fa-pencil"></i> Update your Knowledge Profile</a></li>
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
                        <strong>Your knowledge profile is not yet complete.</strong><br>
                        <a href="/survey/profile" class="primary">Continue</a>
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
                            <td rowspan="2" width="20%">Name</td>
                            <td rowspan="2" width="15%">Unit</td>
                            <td colspan="{{ $area_groups->count() }}" width="65%">Expertise</td>
                        </tr>
                        <tr>
                            @foreach($area_groups as $group)
                                <td width="{{ 65 / $area_groups->count() }}%" class="sub-header">{{ $group->name }}</td>
                            @endforeach
                        </tr>
                        <tr class="hide-print hide-m">
                            <td class="hide-m sub-header">
                            </td>
                            <td class="hide-m sub-header">
                                {{ Form::open(['url' => 'survey/search']) }}
                                {{ Form::select('filter_value', $units, Session::has('survey.Filters.unit_id') ? Session::get('survey.Filters.unit_id') : null, ['class' => 'list-table-filter']) }}
                                {{ Form::hidden('filter_field', 'unit_id') }}
                                {{ Form::hidden('filter_results', 'yes') }}
                                {{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
                                {{ Form::close() }}
                            </td>
                            @foreach($area_groups as $group)
                                <td class="hide-m sub-header">
                                    {{ Form::open(['url' => 'survey/search']) }}
                                    {{ Form::select('filter_value', $areas[$group->id], Session::has('survey.Filters.knowledge_area_id') ? Session::get('survey.Filters.knowledge_area_id') : null, ['class' => 'list-table-filter']) }}
                                    {{ Form::hidden('filter_field', 'knowledge_area_id') }}
                                    {{ Form::hidden('filter_results', 'yes') }}
                                    {{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
                                    {{ Form::close() }}
                                </td>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $profile)
                            <?php
                                $user_expertise = [];
                                foreach($area_groups as $area) {
                                    /*Get user expertise with a score of 4 or 5*/
                                    $user_expertise[] = array_unique($profile->knowledge_areas()->where('knowledge_area_group_id', '=', $area->id)->where('score', '>=', 4)->get()->lists('name'));
                                }
                            ?>
                            <tr>
                                <td><a href="{{ route('survey.show', $profile->id) }}"><strong>{{ $profile->getFullName() }}</strong></a></td>
                                <td><a href="{{ route('units.show', $profile->unit()->first()->id) }}">{{ $profile->unit()->first()->name }}</a></td>
                                @foreach($user_expertise as $expertise)
                                    <td>{{ $expertise ? implode($expertise, ', ') : '-' }}</td>
                                @endforeach
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
