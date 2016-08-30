@extends('layouts.master')

@section('page-header')
    @if(is_search()) <i class="fa fa-search"></i> Searching for {{ Session::has('cases.SearchType') ? Session::get('cases.SearchType') : '' }}: {{ $items->search_term }} @elseif($user->hasRole('Administrator')) Case Studies Overview @else Your Case Studies @endif
@stop

@section('page-nav')
    <li><a href="{{ route('cases.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Case Study</a></li>
@stop

@section('export-nav')
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
                            <td width="60%">Title</td>
                            <td width="5%">Year</td>
                            @if($user->hasRole('Administrator'))
                                <td width="10%" class="hide-s">Unit</td>
                            @endif
                            <td width="10%" class="hide-m">Sector</td>
                            <td width="10%" class="hide-m">Product(s)</td>
                            <td width="10%" class="hide-m">Location</td>
                            <td width="10%" class="hide-m">AD</td>

                            @if($user->hasRole('Administrator'))
                                <td colspan="2" class="hide-print">Actions</td>
                            @else
                                <td class="hide-print">Actions</td>
                            @endif

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $case)
                            <tr>
                                <td><strong><a href="{{ route('cases.show', ['id' => $case->id]) }}">{{ $case->name }}</a></strong></td>
                                <td>{{ $case->year }}</td>

                                @if($user->hasRole('Administrator'))
                                    <td class="hide-s"><strong><a href="/units/{{ $case->unit()->pluck('id') }}">{{ $case->unit()->pluck('name') }}</a></strong></td>
                                @endif

                                <td class="hide-m">{{ $case->sector()->pluck('name') }}</td>
                                <td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
                                <td class="hide-m">{{ $case->location()->pluck('name') }}</td>
                                <td class="hide-m">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>

                                <td class="actions hide-print content-center">
                                    {{ Form::open(['route' => array('cases.edit', $case->id), 'method' => 'get']) }}
                                    <button type="submit" class="primary" title="Edit this case study"><i class="fa fa-pencil"></i></button>
                                    {{ Form::close() }}
                                </td>

                                @if($user->hasRole('Administrator'))
                                    <td class="actions hide-print content-center">
                                        {{ Form::open(['route' => array('cases.destroy', $case->id), 'method' => 'delete']) }}
                                        <button type="submit" class="red-but delete-row" data-resource-type="case study" title="Delete this case study"><i class="fa fa-times"></i></button>
                                        {{ Form::close() }}
                                    </td>
                                @endif
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