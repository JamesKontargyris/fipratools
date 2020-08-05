@extends('layouts.master')

@section('page-header')
Archive records for {{ $client->name }}
@stop

@section('page-nav')
<li><a href="{{ route('clients.index') }}" class="primary"><i class="fa fa-caret-left"></i> Clients Overview</a></li>
<li><a href="{{ route('client_archives.create', ['client_id' => $client->id]) }}" class="primary"><i class="fa fa-plus-circle"></i> Add an Archive Record</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

@if(count($items) > 0)
	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td width="15%" class="content-center">Date</td>
							<td width="15%" class="content-center">Unit</td>
							<td width="15%" class="content-center">Account Director</td>
							<td width="70%">Comment</td>
							<td colspan="2" class="hide-print">Actions</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $client_archive)
							<tr>
								<td class="content-center">{{ date('j M Y', strtotime($client_archive->date)) }}</td>
								<td class="content-center">{{ $client_archive->unit }}</td>
								<td class="content-center">{{ $client_archive->account_director }}</td>
								<td>{{ $client_archive->comment }}</td>

								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('client_archives.edit', $client_archive->id), 'method' => 'get']) }}
										{{ Form::hidden('client_id', $client->id) }}
										<button type="submit" class="primary" title="Edit this client archive record"><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('client_archives.destroy', $client_archive->id), 'method' => 'delete']) }}
										{{ Form::hidden('client_id', $client->id) }}
										<button type="submit" class="red-but delete-row" data-resource-type="client archive record" title="Delete this client archive record"><i class="fa fa-times"></i></button>
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