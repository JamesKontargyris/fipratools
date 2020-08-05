@extends('layouts.master')

@section('page-header')
    {{ $client->name }} @if($client->status == 0) (Dormant)@endif
@stop

@section('page-nav')
    <li><a href="{{ URL::previous() }}" class="primary"><i class="fa fa-caret-left"></i> Go back</a></li>
    @if($user->unit_id == $client->unit_id)
        <li><a href="/clients/{{ $client->id }}/edit" class="primary"><i class="fa fa-pencil"></i> Edit this
        client</a></li>
    @endif
    <li><a href="{{ route('cases.create', ['client_id' => $client->id]) }}" class="primary"><i
                    class="fa fa-plus-circle"></i> Add a Case Study</a></li>
@stop

@section('content')

    @include('layouts.partials.messages')
    <div class="border-box fill section-list">
        <div class="border-box__header">
            Lead Network Member: <a href="{{ route('units.show', $client->unit()->pluck('id')) }}">{{ $client->unit()->pluck('name') }}</a>
        </div>
        <div class="border-box__content border-box__content--text-medium">
            <div class="row no-margin">
                <div class="col-3">
                    <div class="border-box__sub-title">Account Director to talk to</div>
                    <p>
                        @if($client->pr_client)
                            <i class="fa fa-asterisk turquoise"></i>
                            @if($client->account_director_id > 0)
                                ({{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
                                )
                            @endif
                            <br/><br/>

                            <em>Mainly PR client. For all RLMFinsbury PR clients, please contact either Rory Chisholm or
                                John Gray in the first instance except where indicated in brackets above.</em>
                        @else
                            {{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
                        @endif
                    </p>

                    <div class="border-box__sub-title">Comments</div>
                    @if($client->comments)
                        <p>{{ $client->comments }}</p>
                    @else
                        <p>No comments</p>
                    @endif
                </div>

                <div class="col-3">
                    <div class="border-box__sub-title">Sector</div>
                    <p>{{ $client->sector()->pluck('name') }}</p>
                    <div class="border-box__sub-title">Expertise Area</div>
                    <p>{{ \Leadofficelist\Sector_categories\Sector_category::find($client->sector()->pluck('category_id'))['name'] }}
                    </p>
                </div>

                <div class="col-3">
                    <div class="border-box__sub-title">Type</div>
                    <p>{{ $client->type()->pluck('name') }}</p>
                    <div class="border-box__sub-title">Service</div>
                    <p>{{ $client->service()->pluck('name') }}</p>
                </div>

                <div class="col-3 last">
                    <div class="border-box__sub-title">This client also has a contract with:</div>
                    @if(count($linked_units))
                        @foreach($linked_units as $unit)
                            <div class="no-margin"><a href="{{ route('units.show', $unit->id) }}">{{ $unit->name }}</a>
                            </div>
                        @endforeach
                    @else
                        <em style="color:darkgrey">No other Network Members</em>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="border-box section-list">

        <div class="border-box__content">
            <div class="border-box__sub-title more-margin-bottom"><i class="fa fa-archive"></i> History</div>
            @if(count($archives) > 0)
                <div class="row">
                    <div class="col-12">
                        <section class="index-table-container">
                            <table width="100%" class="index-table">
                                <thead>
                                <tr>
                                    <td width="15%" class="content-center">Date</td>
                                    <td width="15%" class="content-center">Unit</td>
                                    <td width="15%" class="content-center">Account Director</td>
                                    <td width="55%">Comment</td>
                                    @if($user->hasRole('Administrator'))
                                        <td colspan="2" class="actions"></td>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($archives as $client_archive)
                                    <tr>
                                        <td class="content-center">{{ date('j M Y', strtotime($client_archive->date)) }}</td>
                                        <td class="content-center">{{ $client_archive->unit }}</td>
                                        <td class="content-center">{{ $client_archive->account_director }}</td>
                                        <td>{{ $client_archive->comment }}</td>
                                        @if($user->hasRole('Administrator'))
                                            <td class="actions content-right hide-print">
                                                {{ Form::open(['route' => array('client_archives.edit', $client_archive->id), 'method' => 'get']) }}
                                                {{ Form::hidden('client_id', $client->id) }}
                                                <button type="submit" class="primary"
                                                        title="Edit this client archive record"><i class="fa fa-pencil"></i>
                                                </button>
                                                {{ Form::close() }}
                                            </td>
                                            <td class="actions content-right hide-print">
                                                {{ Form::open(['route' => array('client_archives.destroy', $client_archive->id), 'method' => 'delete']) }}
                                                {{ Form::hidden('client_id', $client->id) }}
                                                <button type="submit" class="red-but delete-row"
                                                        data-resource-type="client archive record"
                                                        title="Delete this client archive record"><i
                                                            class="fa fa-times"></i></button>
                                                {{ Form::close() }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            @else
                @include('layouts.partials.index_no_records_found')
            @endif
        </div>

    </div>

    <div class="border-box section-list">

        <div class="border-box__content">
            <div class="border-box__sub-title more-margin-bottom"><i class="fa fa-file-text-o"></i> Case Studies</div>
            @if($client->case_studies()->count())
                <section class="index-table-container">
                    <table width="100%" class="index-table">
                        <thead>
                        <tr>
                            <td width="5%">Year</td>
                            <td width="10%" class="hide-m">Sector</td>
                            <td width="30%" class="hide-m">Product(s)</td>
                            @if($user->hasRole('Administrator'))
                                <td width="10%" class="hide-s">Unit</td>
                            @endif
                            <td width="25%" class="hide-m">AD at the time</td>
                            <td width="35%">Background</td>
                            <td width="10%"></td>

                            @if($user->hasRole('Administrator'))
                                <td colspan="3" class="hide-print">Actions</td>
                            @endif

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->case_studies()->where('status', '=', 1)->get() as $case)
                            <tr>
                                <td>{{ $case->year }}</td>

                                <td class="hide-m">{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</td>
                                <td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>

                                @if($user->hasRole('Administrator'))
                                    <td class="hide-s"><strong><a
                                                    href="/units/{{ $case->unit()->pluck('id') }}">{{ $case->unit()->pluck('name') }}</a></strong>
                                    </td>
                                @endif

                                <td class="hide-m">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
                                <td>{{ $case->name }} {{--Background--}} </td>
                                <td width="10%"><a href="{{ route('cases.show', $case->id) }}">View</a></td>

                                @if($user->hasRole('Administrator'))
                                    {{--Case approval/disapproval button based on status of case--}}
                                    @if( ! $case->status)
                                        <td class="actions hide-print content-center">
                                            {{ Form::open(['url' => array('cases/status_approve'), 'method' => 'get']) }}
                                            {{ Form::hidden('case_id', $case->id) }}
                                            <button type="submit" class="primary green-but"
                                                    title="Approve this case study"><i class="fa fa-thumbs-up"></i>
                                            </button>
                                            {{ Form::close() }}
                                        </td>
                                    @else
                                        <td class="actions hide-print content-center">
                                            {{ Form::open(['url' => array('cases/status_disapprove'), 'method' => 'get']) }}
                                            {{ Form::hidden('case_id', $case->id) }}
                                            <button type="submit" class="primary orange-but"
                                                    title="Disapprove this case study"><i class="fa fa-thumbs-down"></i>
                                            </button>
                                            {{ Form::close() }}
                                        </td>
                                    @endif
                                @endif


                                @if($user->hasRole('Administrator'))
                                    <td class="actions hide-print content-center">
                                        {{ Form::open(['route' => array('cases.edit', $case->id), 'method' => 'get']) }}
                                        <button type="submit" class="primary" title="Edit this case study"><i
                                                    class="fa fa-pencil"></i></button>
                                        {{ Form::close() }}
                                    </td>
                                    <td class="actions hide-print content-center">
                                        {{ Form::open(['route' => array('cases.destroy', $case->id), 'method' => 'delete']) }}
                                        <button type="submit" class="red-but delete-row" data-resource-type="case study"
                                                title="Delete this case study"><i class="fa fa-times"></i></button>
                                        {{ Form::close() }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            @else
                @include('layouts.partials.index_no_records_found')
            @endif
        </div>

    </div>

@stop