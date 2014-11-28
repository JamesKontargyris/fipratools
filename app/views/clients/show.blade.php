@extends('layouts.master')

@section('page-header')
{{ $client->name }}
@stop

@section('page-nav')
@if($user->unit_id == $client->unit_id)
	<li><a href="/clients/{{ $client->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this client</a></li>
@endif
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6 border-box fill">
		<h3>Lead Unit</h3>
		<h4>{{ $client->unit()->pluck('name') }}</h4>
		<p>{{ $client->getLeadOfficeAddress() }}</p>
		<h4>Account Director to talk to</h4>
		<p>
			@if($client->pr_client)
				<i class="fa fa-asterisk turquoise"></i>
				@if($client->account_director_id > 0)
					({{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }})
				@endif
				<br/><br/>

				<em>Mainly PR client. For all RLMFinsbury PR clients, please contact either Rory Chisholm or John Gray in the first instance except where indicated in brackets above.</em>
			@else
				{{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
			@endif
		</p>
	</div>
	<div class="col-6 last">
		@if(count($linked_units))
			<div class="border-box">
				<h3>This client also has a contract with:</h3>
				@foreach($linked_units as $unit)
					<h4>{{ $unit->name }}</h4>
					<p>{{ $unit->addressOneLine() }}</p>
				@endforeach
			</div>
		@endif
		<h3>Comments</h3>
		@if($client->comments)
			<p>{{ $client->comments }}</p>
		@else
			<p>No comments</p>
		@endif
		<h4>Details</h4>
		<p><strong>Sector:</strong> {{ $client->sector()->pluck('name') }}</p>
		<p><strong>Type:</strong> {{ $client->type()->pluck('name') }}</p>
		<p><strong>Service:</strong> {{ $client->service()->pluck('name') }}</p>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<h3>History</h3>
	</div>
</div>

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
											<button type="submit" class="primary" title="Edit this client archive record"><i class="fa fa-pencil"></i></button>
										{{ Form::close() }}
									</td>
									<td class="actions content-right hide-print">
										{{ Form::open(['route' => array('client_archives.destroy', $client_archive->id), 'method' => 'delete']) }}
											{{ Form::hidden('client_id', $client->id) }}
											<button type="submit" class="red-but delete-row" data-resource-type="client archive record" title="Delete this client archive record"><i class="fa fa-times"></i></button>
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
@stop