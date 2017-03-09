@extends('layouts.master')

@section('page-header')
{{ $client->name }}
@stop

@section('page-nav')
@if($user->unit_id == $client->unit_id)
	<li><a href="/clients/{{ $client->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this client</a></li>
@endif
	<li><a href="{{ route('cases.create', ['client_id' => $client->id]) }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Case Study</a></li>
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6 border-box fill">
		<h4>Lead Network Member</h4>
		<h3><a href="{{ route('units.show', $client->unit()->pluck('id')) }}">{{ $client->unit()->pluck('name') }}</a></h3>
		@if(count($linked_units))
			<div class="border-box no-margin">
				<h5>This client also has a contract with:</h5>
				@foreach($linked_units as $unit)
					<div class="no-margin"><a href="{{ route('units.show', $unit->id) }}">{{ $unit->name }}</a></div>
				@endforeach
			</div>
		@endif
		<p>{{ $client->getLeadOfficeAddress() }}</p>
		<h4>Account Director to talk to</h4>
		<h3>
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
		</h3>
	</div>
	<div class="col-6 last">
		<h4>Comments</h4>
		@if($client->comments)
			<p>{{ $client->comments }}</p>
		@else
			<p>No comments</p>
		@endif
		<h4>Details</h4>
		<p><strong>Sector:</strong> {{ $client->sector()->pluck('name') }}</p>
		<p><strong>Expertise Area:</strong> {{ \Leadofficelist\Sector_categories\Sector_category::find($client->sector()->pluck('id'))['name'] }}</p>
		<p><strong>Type:</strong> {{ $client->type()->pluck('name') }}</p>
		<p><strong>Service:</strong> {{ $client->service()->pluck('name') }}</p>
	</div>
</div>

<div class="row no-margin">
	<div class="col-12">
		<h3>Case Studies</h3>
	</div>
</div>

@if($client->case_studies()->count())
	<div class="row">
		<div class="col-12">
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
						<td width="10%" class="hide-s">Status</td>

						@if($user->hasRole('Administrator'))
							<td colspan="3" class="hide-print">Actions</td>
						@endif

					</tr>
					</thead>
					<tbody>
					@foreach($client->case_studies()->get() as $case)
						<tr>
							<td>{{ $case->year }}</td>

							<td class="hide-m">{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</td>
							<td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>

							@if($user->hasRole('Administrator'))
								<td class="hide-s"><strong><a href="/units/{{ $case->unit()->pluck('id') }}">{{ $case->unit()->pluck('name') }}</a></strong></td>
							@endif

							<td class="hide-m">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
							<td>{{ $case->name }} {{--Background--}} </td>
							<td width="10%" class="hide-s">{{ ! $case->status ? '<span class="status--pending">Pending</span>' : '<span class="status--active">Active</span>'}}</td>

							@if($user->hasRole('Administrator'))
								{{--Case approval/disapproval button based on status of case--}}
								@if( ! $case->status)
									<td class="actions hide-print content-center">
										{{ Form::open(['url' => array('cases/status_approve'), 'method' => 'get']) }}
										{{ Form::hidden('case_id', $case->id) }}
										<button type="submit" class="primary green-but" title="Approve this case study"><i class="fa fa-thumbs-up"></i></button>
										{{ Form::close() }}
									</td>
								@else
									<td class="actions hide-print content-center">
										{{ Form::open(['url' => array('cases/status_disapprove'), 'method' => 'get']) }}
										{{ Form::hidden('case_id', $case->id) }}
										<button type="submit" class="primary orange-but" title="Disapprove this case study"><i class="fa fa-thumbs-down"></i></button>
										{{ Form::close() }}
									</td>
								@endif
							@endif


						@if($user->hasRole('Administrator'))
								<td class="actions hide-print content-center">
									{{ Form::open(['route' => array('cases.edit', $case->id), 'method' => 'get']) }}
									<button type="submit" class="primary" title="Edit this case study"><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions hide-print content-center">
									{{ Form::open(['route' => array('cases.destroy', $case->id), 'method' => 'delete']) }}
									<button type="submit" class="red-but delete-row" data-resource-type="case study" title="Delete this case study"><i class="fa fa-times"></i></button>
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

<div class="row no-margin">
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