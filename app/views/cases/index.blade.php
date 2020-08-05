@extends('layouts.master')

@section('page-header')
    @if(is_search()) <i class="fa fa-search"></i> Searching for {{ Session::has('cases.SearchType') ? Session::get('cases.SearchType') : '' }}: {{ $items->search_term }} @elseif($user->hasRole('Administrator')) Case Studies Overview @else Your Case Studies @endif
@stop

@section('page-nav')
    <li><a href="{{ route('cases.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a Case Study</a></li>
@stop

@section('export-nav')
@stop

@section('content')

    @include('layouts.partials.messages')

    {{--Active case studies--}}
    <div class="row no-margin">
        <div class="col-12">
            <h4>Active</h4>
        </div>
    </div>
    @if(count($items) > 0)
        @include('layouts.partials.rows_nav')

        @include('layouts.partials.filters')

        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                            <tr>
                                <td width="5%">Year</td>
                                <td width="10%">Client where disclosable</td>
                                <td width="25%">Background</td>
                                @if($user->hasRole('Administrator'))
                                    <td width="10%" class="hide-s">Unit</td>
                                @endif
                                <td colspan="2" width="25%" class="hide-m">Sector(s) and Expertise Area(s)</td>
                                <td width="20%" class="hide-m">Product(s)</td>
                                <td width="10%" class="hide-m">AD at the time</td>
                                <td width="10%" class="hide-s">Status</td>

                                @if($user->hasRole('Administrator'))
                                    <td colspan="3" class="hide-print">Actions</td>
                                @else
                                    <td class="hide-print">Actions</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $case)
                            <tr>
                                <td>{{ $case->year }}</td>
                                <td>{{ ! $case->client_id ? (! $case->client ? 'Anonymous' : $case->client) : '<a
                                            href="' . route('clients.show', $case->client()->first()->id) . '"><strong>' . $case->client()->first()->name . '</strong></a>' }}</td>
                                <td>{{ $case->name }} {{--Background--}} </td>
                                @if($user->hasRole('Administrator'))
                                    <td class="hide-s"><strong><a href="/units/{{ $case->unit()->pluck('id') }}">{{ $case->unit()->pluck('name') }}</a></strong></td>
                                @endif
                                <td class="hide-m">{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</td>
                                <td class="hide-m expertise-field">
	                                <?php
	                                // Get the expertise areas (called Sector Areas here) that are associated with each sector
	                                $sectors = unserialize($case->sector_id);
	                                $expertiseAreas = [];
	                                foreach($sectors as $sector) {
		                                if($sectorObj = \Leadofficelist\Sectors\Sector::find($sector)) {
			                                $expertiseAreas[] = \Leadofficelist\Sector_categories\Sector_category::find($sectorObj->category_id)['name'];
		                                }
	                                }
	                                ?>

                                    @if($expertiseAreas)
                                        <div class="expertise-field__text-container">
                                            {{ implode(array_unique($expertiseAreas), ' &bull; ') }}
                                            <i class="fa fa-caret-left fa-lg expertise-field__pointer"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
                                <td class="hide-m">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
                                <td width="10%" class="hide-s">{{ ! $case->status ? '<span class="status--pending">Pending</span>' : '<span class="status--active">Active</span>'}}</td>

                                @if($user->hasRole('Administrator'))
                                    {{--Case approval/disapproval button based on status of case--}}
                                    @if( ! $case->status)
                                        <td class="actions hide-print content-center">
                                            {{ Form::open(['url' => array('cases/status_approve'), 'method' => 'get']) }}
                                            {{ Form::hidden('case_id', $case->id) }}
                                            <button type="submit" class="primary green-but" title="Approve this case study"><i class="fa fa-thumbs-up"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                    @else
                                        <td class="actions hide-print content-center">
                                            {{ Form::open(['url' => array('cases/status_disapprove'), 'method' => 'get']) }}
                                            {{ Form::hidden('case_id', $case->id) }}
                                            <button type="submit" class="primary orange-but" title="Disapprove this case study"><i class="fa fa-thumbs-down"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                    @endif
                                @endif

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

    {{--Pending case studies--}}
    <div class="row no-margin">
        <div class="col-12">
            <h4>Pending</h4>
        </div>
    </div>
    @if(count($items_pending) > 0)
        <section class="index-table-container">
            <div class="row">
                <div class="col-12">
                    <table width="100%" class="index-table">
                        <thead>
                            <tr>
                                <td width="5%">Year</td>
                                <td width="10%">Client where disclosable</td>
                                <td width="25%">Background</td>
                                @if($user->hasRole('Administrator'))
                                    <td width="10%" class="hide-s">Unit</td>
                                @endif
                                <td colspan="2" width="25%" class="hide-m">Sector(s) and Expertise Area(s)</td>
                                <td width="20%" class="hide-m">Product(s)</td>
                                <td width="10%" class="hide-m">AD at the time</td>
                                <td width="10%" class="hide-s">Status</td>

                                @if($user->hasRole('Administrator'))
                                    <td colspan="3" class="hide-print">Actions</td>
                                @else
                                    <td class="hide-print">Actions</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($items_pending as $case)
                            <tr>
                                <td>{{ $case->year }}</td>
                                <td>{{ ! $case->client_id ? (! $case->client ? 'Anonymous' : $case->client) : '<a
                                            href="' . route('clients.show', $case->client()->first()->id) . '"><strong>' . $case->client()->first()->name . '</strong></a>' }}</td>
                                <td>{{ $case->name }} {{--Background--}} </td>
                                @if($user->hasRole('Administrator'))
                                    <td class="hide-s"><strong><a href="/units/{{ $case->unit()->pluck('id') }}">{{ $case->unit()->pluck('name') }}</a></strong></td>
                                @endif
                                <td class="hide-m">{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</td>
                                <td class="hide-m expertise-field">
		                            <?php
		                            // Get the expertise areas (called Sector Areas here) that are associated with each sector
		                            $sectors = unserialize($case->sector_id);
		                            $expertiseAreas = [];
		                            foreach($sectors as $sector) {
			                            if($sectorObj = \Leadofficelist\Sectors\Sector::find($sector)) {
				                            $expertiseAreas[] = \Leadofficelist\Sector_categories\Sector_category::find($sectorObj->category_id)['name'];
			                            }
		                            }
		                            ?>

                                    @if($expertiseAreas)
                                        <div class="expertise-field__text-container">
                                            {{ implode(array_unique($expertiseAreas), ' &bull; ') }}
                                            <i class="fa fa-caret-left fa-lg expertise-field__pointer"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
                                <td class="hide-m">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
                                <td width="10%" class="hide-s">{{ ! $case->status ? '<span class="status--pending">Pending</span>' : '<span class="status--active">Active</span>'}}</td>

                                @if($user->hasRole('Administrator'))
                                    {{--Case approval/disapproval button based on status of case--}}
                                    @if( ! $case->status)
                                        <td class="actions hide-print content-center">
                                            {{ Form::open(['url' => array('cases/status_approve'), 'method' => 'get']) }}
                                            {{ Form::hidden('case_id', $case->id) }}
                                            <button type="submit" class="primary green-but" title="Approve this case study"><i class="fa fa-thumbs-up"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                    @else
                                        <td class="actions hide-print content-center">
                                            {{ Form::open(['url' => array('cases/status_disapprove'), 'method' => 'get']) }}
                                            {{ Form::hidden('case_id', $case->id) }}
                                            <button type="submit" class="primary orange-but" title="Disapprove this case study"><i class="fa fa-thumbs-down"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                    @endif
                                @endif

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