@extends('layouts.master')

@section('page-header')
{{ $unit->name }}
@stop

@section('page-nav')
@if($user->can('manage_units'))
	<li><a href="/units/{{ $unit->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this unit</a></li>
@endif
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6">
		<h4>Address:</h4>
		<p>
			{{ $unit->address1 }}<br/>
			{{ ! empty($unit->address2) ? $unit->address2 . '<br/>' : '' }}
			{{ ! empty($unit->address3) ? $unit->address3 . '<br/>' : '' }}
			{{ ! empty($unit->address4) ? $unit->address4 . '<br/>' : '' }}
			{{ $unit->post_code }}
		</p>
		@if( ! empty($unit->phone))
			<h4>Telephone:</h4>
			<p>{{ $unit->phone }}</p>
		@endif
		@if( ! empty($unit->fax))
			<h4>Fax:</h4>
			<p>{{ $unit->fax }}</p>
		@endif
		@if( ! empty($unit->email))
			<h4>Email:</h4>
			<p>{{ $unit->email }}</p>
		@endif
	</div>
	<div class="col-6 last">
		@if($unit->post_code)
			<iframe
			  width="600"
			  height="450"
			  frameborder="0" style="border:0"
			  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyATzzmmT075GUyVS_4EGw_RJCGc7P77sUo&q={{ $unit->addressOneLine() }}">
			</iframe>
		@endif
	</div>
</div>

<div class="row">
	<h3>Active clients linked to this unit</h3>
</div>

@if($user->hasRole('Administrator') && count($clients) > 0)
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