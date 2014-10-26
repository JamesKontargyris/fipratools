@extends('layouts.master')

@section('page-header')
@if(is_search()) <i class="fa fa-search"></i> Searching for {{ Session::has('clients.SearchType') ? Session::get('clients.SearchType') : '' }}: {{ $items->search_term }} @elseif($user->hasRole('Administrator')) Clients Overview @else Your Clients @endif
@stop

@section('page-nav')
<li><a class="print-button" href="#"><i class="fa fa-print"></i> Print</a></li>
<li><a href="/clients/export?filetype=pdf_all"><i class="fa fa-file-pdf-o"></i> Export All to PDF</a></li>
<li class="divider-right"><a href="/clients/export?filetype=pdf_selection"><i class="fa fa-file-pdf-o"></i> Export Visible to PDF</a></li>
<li><a href="{{ route('clients.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Client</a></li>
@if($user->hasRole('Administrator'))
	<li><a href="{{ route('client_links.create') }}" class="secondary"><i class="fa fa-link"></i> Create a Client/Unit Link</a></li>
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
							@if(Session::get( 'clients.rowsHideShowDormant' ) == 'show')
								<td class="content-center show-s"></td>
								<td class="content-center hide-s">Status</td>
							@endif
							<td colspan="3" width="60%">Client name</td>
							@if($user->hasRole('Administrator'))
								<td width="10%" class="hide-s">Unit</td>
							@endif
							<td width="15%" class="hide-m">Sector</td>
							<td width="15%" class="hide-m">Type</td>
							<td width="10%" class="hide-m">Service</td>

							@if($user->hasRole('Administrator'))
								<td colspan="4" class="hide-print">Actions</td>
							@else
								<td class="hide-print">Actions</td>
							@endif

							<td class="hide-s hide-print">Toggle Status</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $client)
							<tr>
								@if(Session::get( 'clients.rowsHideShowDormant' ) == 'show')
									@if($client->status)
										<td class="actions content-center status-active show-s"><i class="fa fa-circle fa-lg show-s"></i></td>
										<td class="actions content-center status-active hide-s">Active</td>
									@else
										<td class="actions content-center status-dormant show-s"><i class="fa fa-circle-o fa-lg show-s"></i></td>
										<td class="actions content-center status-dormant hide-s">Dormant</td>
									@endif
								@endif
								<td><strong><a href="{{ route('clients.show', ['id' => $client->id]) }}">{{ $client->name }}</a></strong></td>
								<td class="archive-count">
									@if($client->archives()->count())
										@if($user->hasRole('Administrator'))
											<a href="{{ route('client_archives.index', ['client_id' => $client->id]) }}"><strong><i class="fa fa-archive"></i> {{ $client->archives()->count() }}</strong></a>
										@else
											<strong><i class="fa fa-archive"></i> {{ $client->archives()->count() }}</strong>
										@endif
									@endif
								</td>
								<td class="client-links">
									@if($client->links()->count())
										@if($user->hasRole('Administrator'))
											<a href="{{ route('client_links.index', ['client_id' => $client->id]) }}"><strong><i class="fa fa-link"></i> {{ $client->getLinkedUnitsList($client->id) }}</strong></a>
										@else
											<strong><i class="fa fa-link"></i> {{ $client->getLinkedUnitsList($client->id) }}</strong>
										@endif
									@endif
								</td>

								@if($user->hasRole('Administrator'))
									<td class="hide-s"><strong><a href="/units/{{ $client->unit()->pluck('id') }}">{{ $client->unit()->pluck('name') }}</a></strong></td>
								@endif

								<td class="hide-m">{{ $client->sector()->pluck('name') }}</td>
								<td class="hide-m">{{ $client->type()->pluck('short_name') }}</td>
								<td class="hide-m">{{ $client->service()->pluck('name') }}</td>

								@if($user->hasRole('Administrator'))
									<td class="actions hide-print content-center">
										{{ Form::open(['route' => 'client_links.create', 'method' => 'get']) }}
											{{ Form::hidden('unit_1', $client->unit()->pluck('id')) }}
											{{ Form::hidden('client_1', $client->id) }}
											<button type="submit" class="grey-but" title="Add a unit link for this client"><i class="fa fa-link"></i></button>
										{{ Form::close() }}
									</td>
									<td class="actions hide-print content-center">
										{{ Form::open(['url' => 'client_archives/create', 'method' => 'get']) }}
											{{ Form::hidden('client_id', $client->id) }}
											<button type="submit" class="primary" title="Add an archive record for this client"><i class="fa fa-archive"></i></button>
										{{ Form::close() }}
									</td>
								@endif

								<td class="actions hide-print content-center">
									{{ Form::open(['route' => array('clients.edit', $client->id), 'method' => 'get']) }}
										<button type="submit" class="primary" title="Edit this client"><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>

								@if($user->hasRole('Administrator'))
									<td class="actions hide-print content-center">
										{{ Form::open(['route' => array('clients.destroy', $client->id), 'method' => 'delete']) }}
											<button type="submit" class="red-but delete-row" data-resource-type="client" title="Delete this client"><i class="fa fa-times"></i></button>
										{{ Form::close() }}
									</td>
								@endif

								<td class="actions hide-print content-center hide-s">
									{{ Form::open(['route' => array('clients.change_status', $client->id), 'method' => 'get']) }}
										{{ Form::hidden('client_id', $client->id) }}
										@if($client->status)
											<button type="submit" class="green-but" title="Make this client dormant"><i class="fa fa-circle"></i></button>
										@else
											<button type="submit" class="grey-but" title="Make this client active"><i class="fa fa-circle-o"></i></button>
										@endif
									{{ Form::close() }}
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