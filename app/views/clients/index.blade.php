@extends('layouts.master')

@section('page-header')
@if(is_search()) Searching for: {{ $items->search_term }} @elseif($user->hasRole('Administrator')) Clients Overview @else Your Clients Overview @endif
@stop

@section('page-nav')
<li><a href="{{ route('clients.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Client</a></li>
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
							<td class="content-center show-s"></td>
							<td width="60%">Client name</td>
							<td width="15%" class="content-center hide-s">Sector</td>
							<td width="15%" class="content-center hide-m">Type</td>
							<td width="10%" class="content-center hide-m">Service</td>
							<td class="content-center hide-s">Status</td>
							<td colspan="3">Actions</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $client)
							<tr>
								@if($client->status)
									<td class="actions content-center status-active show-s"><i class="fa fa-circle fa-lg show-s"></i></td>
								@else
									<td class="actions content-center status-dormant show-s"><i class="fa fa-circle-o fa-lg show-s"></i></td>
								@endif
								<td><strong><a href="{{ route('clients.show', ['id' => $client->id]) }}">{{ $client->name }}</a></strong></td>
								<td class="content-center hide-s">{{ $client->sector()->pluck('name') }}</td>
								<td class="content-center hide-m">{{ $client->type()->pluck('name') }}</td>
								<td class="content-center hide-m">{{ $client->service()->pluck('name') }}</td>
								@if($client->status)
									<td class="actions content-center status-active hide-s">Active</td>
								@else
									<td class="actions content-center status-dormant hide-s">Dormant</td>
								@endif
								<td class="actions content-right">
									{{ Form::open(['url' => 'clients/' . $client->id . '/archive', 'method' => 'get']) }}
										<button type="submit" class="primary" title="Add an archive entry for this client"><i class="fa fa-folder"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right">
									{{ Form::open(['route' => array('clients.edit', $client->id), 'method' => 'get']) }}
										<button type="submit" class="primary" title="Edit this client"><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right">
									{{ Form::open(['route' => array('clients.destroy', $client->id), 'method' => 'delete']) }}
										<button type="submit" class="red-but delete-row" data-resource-type="sector" title="Delete this client"><i class="fa fa-times"></i></button>
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