@extends('layouts.master')

@section('page-header')
{{ $show_user->getFullName() }} @if($show_user->unit()->pluck('name'))({{ $show_user->unit()->pluck('name') }})@endif
@stop

@section('page-nav')
@if($user->can('manage_users'))
	<li><a href="/users/{{ $show_user->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this user</a></li>
@endif
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6">
	</div>
</div>

<h3>Active clients added by this user</h3>
@if($user->hasRole('Administrator') && count($clients) > 0)
	<div class="row">
	</div>
	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td width="60%">Name</td>
							<td width="15%" class="content-center hide-s">Sector</td>
							<td width="15%" class="content-center hide-m">Type</td>
							<td width="10%" class="content-center hide-m">Service</td>
							<td colspan="3">Actions</td>
						</tr>
					</thead>
					<tbody>
						@foreach($clients as $client)
							<tr>
								<td><strong><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></strong></td>
								<td class="content-center hide-s">{{ $client->sector()->pluck('name') }}</td>
								<td class="content-center hide-m">{{ $client->type()->pluck('name') }}</td>
								<td class="content-center hide-m">{{ $client->service()->pluck('name') }}</td>
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
@else
	@include('layouts.partials.index_no_records_found')
@endif
@stop