@extends('layouts.list')

@section('page-header')
    @if(is_filter($items->key))
        <i class="fa fa-filter"></i> Filtering on: {{ $items->filter_value }}

    @elseif(is_search())
        <i class="fa fa-search"></i> Searching for {{ Session::has('headofunitsurvey.SearchType') ? Session::get('headofunitsurvey.SearchType') : '' }}: {{ $items->search_term }}
    @else
        Head of Unit Survey Profiles
    @endif
@stop

@section('page-nav')
@stop

@section('content')

    @include('layouts.partials.messages')

    @if(count($items) > 0)

        @include('layouts.partials.rows_nav')

        @include('layouts.partials.filters')

        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                        <tr>
                            <td width="40%">Name</td>
                            <td width="35%" class="hide-m">Unit</td>
                            <td width="15%">Sections Completed</td>
                            <td width="10%">Answers Given</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $profile)
                            <tr>
                                <td><a href="{{ route('headofunitsurvey.show', $profile->id) }}"><strong>{{ $profile->getFullName() }}</strong></a></td>
                                <td class="hide-m">
                                    @if(isset($profile->unit()->first()->id))<a href="{{ route('units.show', $profile->unit()->first()->id) }}">{{ $profile->unit()->first()->name }}</a>@endif
                                </td>
                                <td>
                                    <?php
                                        $sections_completed_count = 0;
                                    ?>

                                    @foreach($section_names as $section_name)
                                        @if(Leadofficelist\Knowledge_data\KnowledgeData::sectionIsComplete($sections, $section_name, $profile->id))
                                            <i class="fa fa-circle text--green"></i>
                                            <?php $sections_completed_count++; ?>
                                            @endif
                                        @endforeach

                                    @for($i = $sections_completed_count; $i < 6; $i++)
                                        <i class="fa fa-circle text--light-grey"></i>
                                    @endfor

                                    &nbsp;&nbsp;{{ $sections_completed_count }} of 6

                                </td>
	                            <?php $answers_count = Leadofficelist\Knowledge_data\KnowledgeData::where('user_id', '=', $profile->id)->where('survey_name', '=', 'head_of_unit_survey')->count(); ?>
                                <td
                                @if($answers_count <= 20 )
                                    style="background-color:#ffc3c5"
                                @elseif($answers_count > 20 && $answers_count <= 34)
                                    style="background-color:#ffd8a6"
                                @else
                                    style="background-color:#ddffa1"
                                @endif
                                >
                                <strong>{{ $answers_count }}</strong>

                                </td>
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
