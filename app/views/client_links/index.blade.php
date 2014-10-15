@extends('layouts.master')

@section('page-header')
Unit links for {{ $client->name }}
@stop

@section('page-nav')
<li><a href="{{ route('clients.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Clients Overview</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-12">
		<h3>Lead Unit: {{ $client->unit()->pluck('name') }}</h3>
	</div>
</div>

@if(count($items) > 0)
	<section class="index-table-container">
		<div class="row">
			<div class="col-6">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td>Other units with contracts with this client</td>
							<td>Actions</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $client_link)
							<tr>
								<td><strong>{{ $client_link->unit()->pluck('name') }}</strong></td>

								<td class="actions content-right">
									{{ Form::open(['route' => array('client_links.destroy', $client_link->id), 'method' => 'delete']) }}
										{{ Form::hidden('client_id', $client->id) }}
										<button type="submit" class="red-but delete-row" data-resource-type="sector" title="Delete this unit"><i class="fa fa-times"></i></button>
									{{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>
@else
	@include('layouts.partials.index_no_records_found')
@endif
@stop