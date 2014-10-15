@extends('layouts.list')

@section('page-header')
@if(is_search())
	<i class="fa fa-search"></i> Searching for {{ Session::has('clients.SearchType') ? Session::get('clients.SearchType') : '' }}: {{ $items->search_term }}
@else
	Clients List
@endif
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
							<td colspan="3" width="40%">Client name</td>
							<td width="10%" class="hide-m">Sector</td>
							<td width="10%" class="hide-m">Type</td>
							<td width="10%" class="hide-m">Service</td>
							<td width="15%">Lead Unit</td>
							<td width="25%" class="hide-m">AD to talk to</td>
						</tr>
						<tr>
							<td class="hide-m sub-header" colspan="3">
								@include('layouts.partials.filters.table-letter-filter')
							</td>
							<td class="hide-m sub-header">
								{{ Form::open() }}
									{{ Form::select('filter-sector', ['Filter...'], null, ['class' => 'list-table-filter']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open() }}
									{{ Form::select('filter-type', ['Filter...'], null, ['class' => 'list-table-filter']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open() }}
									{{ Form::select('filter-service', ['Filter...'], null, ['class' => 'list-table-filter']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open() }}
									{{ Form::select('filter-unit', ['Filter...'], null, ['class' => 'list-table-filter']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open() }}
									{{ Form::select('filter-accountdirector', ['Filter...'], null, ['class' => 'list-table-filter']) }}
								{{ Form::close() }}
							</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $client)
							<tr>
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
								<td><a href="{{ route('units.show', ['id' => $client->unit()->pluck('id')]) }}"> {{ $client->unit()->pluck('name') }}</a></td>
								<td class="hide-s">{{ $client->account_director }}</td>
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