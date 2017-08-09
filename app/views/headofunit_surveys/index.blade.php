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
    <li><a href="{{ url('/headofunitsurvey/profile/edit') }}" class="secondary"><i class="fa fa-pencil"></i> Update your Head of Unit Profile</a></li>
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
                            <td rowspan="2" width="20%">Name</td>
                            <td rowspan="2" width="15%" class="hide-m">Unit</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $profile)
                            <tr>
                                <td><a href="{{ route('headofunitsurvey.show', $profile->id) }}"><strong>{{ $profile->getFullName() }}</strong></a></td>
                                <td class="hide-m">
                                    @if(isset($profile->unit()->first()->id))<a href="{{ route('units.show', $profile->unit()->first()->id) }}">{{ $profile->unit()->first()->name }}</a>@endif
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
