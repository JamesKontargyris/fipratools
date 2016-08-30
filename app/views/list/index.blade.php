@extends('layouts.list')

@section('page-header')
@if(is_filter())
	<i class="fa fa-filter"></i> Filtering on: {{ $items->filter_value }}

@elseif(is_search())
	<i class="fa fa-search"></i> Searching for {{ Session::has('list.SearchType') ? Session::get('list.SearchType') : '' }}: {{ $items->search_term }}
@else
    @if(Session::get('list.rowsHideShowActive') == 'show') Active @endif
    @if(Session::get('list.rowsHideShowActive') == 'show' && Session::get('list.rowsHideShowDormant') == 'show') and @endif
    @if(Session::get('list.rowsHideShowDormant') == 'show') Dormant @endif
    Clients
@endif
@stop

@section('page-nav')
	@if($user->can('manage_clients'))
		<li><a href="{{ route('clients.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Client</a></li>
	@endif
	<li><a href="{{ url('reports') }}" class="secondary"><i class="fa fa-pie-chart"></i> View Reports</a></li>
@stop

@section('content')

@include('layouts.partials.messages')



@if(count($items) > 0)

	<div class="row no-margin">
		<div class="col-12" style="font-size:16px; font-weight:bold; text-align: center;">
            A Dormant Client is one last billed over three months and up to 12 months ago.
		</div>
	</div>
	@include('layouts.partials.rows_nav')

	@include('layouts.partials.filters')

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td colspan="4" width="40%">Client name</td>
							<td width="10%" class="hide-m">Sector</td>
							<td width="10%" class="hide-m">Type</td>
							<td width="10%" class="hide-m">Service</td>
							<td width="15%">Lead Member</td>
							<td width="25%" class="hide-s">AD to talk to</td>
						</tr>
						<tr class="hide-print">
							<td class="hide-m sub-header" colspan="4">
								@include('layouts.partials.filters.table-letter-filter')
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'list/search']) }}
									{{ Form::select('filter_value', $sectors, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'sector_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'list/search']) }}
									{{ Form::select('filter_value', $types, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'type_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'list/search']) }}
									{{ Form::select('filter_value', $services, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'service_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'list/search']) }}
									{{ Form::select('filter_value', $units, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'unit_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'list/search']) }}
									{{ Form::select('filter_value', $account_directors, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'account_director_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $client)
							<tr @if( ! $client->status) class="dormant" @endif>
                                @if($client->status)
                                    <td class="actions content-center status-active"><i class="fa fa-check-circle fa-lg"></i></td>
                                @else
                                    <td class="actions content-center status-dormant"><i class="fa fa-times-circle fa-lg"></i></td>
                                @endif
								<td><strong><a href="{{ route('clients.show', ['id' => $client->id]) }}">{{ $client->name }}</a></strong></td>
								<td class="archive-count">
									@if($client->archives()->count())
										<strong><i class="fa fa-archive"></i> {{ $client->archives()->count() }}</strong>
									@endif
								</td>
								<td class="client-links">
									@if($client->links()->count())
										<strong><i class="fa fa-link"></i> {{ $client->getLinkedUnitsList($client->id) }}</strong>
									@endif
								</td>
								<td class="hide-m">{{ $client->sector()->pluck('name') }}</td>
								<td class="hide-m">{{ $client->type()->pluck('short_name') }}</td>
								<td class="hide-m">{{ $client->service()->pluck('name') }}</td>
								<td><a href="{{ route('units.show', ['id' => $client->unit()->pluck('id')]) }}"><strong>{{ $client->unit()->pluck('name') }}</strong></a></td>
								<td class="hide-s">
									@if($client->pr_client)
										@if($client->account_director_id > 0)
											{{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
										@endif
									@else
										{{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
									@endif
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