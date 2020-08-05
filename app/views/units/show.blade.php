@extends('layouts.master')

@section('page-header')
{{ $unit->name }}
@stop

@section('page-nav')
@if($user->can('manage_units'))
	<li><a href="{{ URL::previous() }}" class="primary"><i class="fa fa-caret-left"></i> Go back</a></li>
	<li><a href="/units/{{ $unit->id }}/edit" class="primary"><i class="fa fa-pencil"></i> Edit this {{ $unit->network_type()->first()->name }}</a></li>
@endif
@stop

@section('content')

@include('layouts.partials.messages')

<div class="border-box fill section-list">
	<div class="border-box__content border-box__content--text-medium">
		<div class="row no-margin">

			@if( ! empty($unit->address1))
				<div class="col-3">
					<div class="border-box__sub-title">Address</div>
					<p class="no-padding">
						{{ $unit->address1 }}<br/>
						{{ ! empty($unit->address2) ? $unit->address2 . '<br/>' : '' }}
						{{ ! empty($unit->address3) ? $unit->address3 . '<br/>' : '' }}
						{{ ! empty($unit->address4) ? $unit->address4 . '<br/>' : '' }}
						{{ $unit->post_code }}
					</p>
				</div>
			@endif
			@if( ! empty($unit->phone))
				<div class="col-2">
					<div class="border-box__sub-title">Telephone</div>
					<p class="no-padding">{{ $unit->phone }}</p>
				</div>
			@endif
			@if( ! empty($unit->fax))
					<div class="col-2">
						<div class="border-box__sub-title">Fax</div>
						<p class="no-padding">{{ $unit->fax }}</p>
					</div>
			@endif
			@if( ! empty($unit->email))
					<div class="col-3">
						<div class="border-box__sub-title">Email</div>
						<p class="no-padding"><a href="mailto:{{ $unit->email }}">{{ $unit->email }}</a></p>
					</div>
			@endif
		</div>
	</div>
</div>

<div class="border-box fill section-list">
	<div class="border-box__content">
		<div class="border-box__sub-title more-margin-bottom"><i class="fa fa-briefcase"></i> Active clients linked to this {{ $unit->network_type()->first()->name }}</div>
		@if(count($clients) > 0)
			<section class="index-table-container">
				<div class="row no-margin">
					<div class="col-12">
						<table width="100%" class="index-table">
							<thead>
							<tr>
								<td width="60%">Name</td>
								<td width="15%" class="hide-s">Sector</td>
								<td width="15%" class="content-center hide-m">Type</td>
								<td width="10%" class="content-center hide-m">Service</td>
								@if($user->hasRole('Administrator'))
									<td colspan="3">Actions</td>
								@endif
							</tr>
							</thead>
							<tbody>
							@foreach($clients as $client)
								<tr class="show-more__row" data-show-more-group="active-clients">
									<td><strong><a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></strong></td>
									<td class="hide-s">{{ $client->sector()->pluck('name') }}</td>
									<td class="hide-m">{{ $client->type()->pluck('name') }}</td>
									<td class="hide-m">{{ $client->service()->pluck('name') }}</td>
									@if($user->hasRole('Administrator'))
										<td class="actions content-right">
											{{ Form::open(['url' => 'client_archives/create', 'method' => 'get']) }}
											{{ Form::hidden('client_id', $client->id) }}
											<button type="submit" class="primary" title="Add an archive entry for this client"><i class="fa fa-archive"></i></button>
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
									@endif
								</tr>
							@endforeach
							</tbody>
						</table>
						<a href="#" class="secondary show-more__button" data-target-group="active-clients">Show more <i class="fa fa-caret-down"></i> </a>
					</div>
				</div>
			</section>
		@else
			@include('layouts.partials.index_no_records_found')
		@endif
	</div>

</div>

<div class="border-box fill section-list">
	<div class="border-box__content">
		<div class="border-box__sub-title more-margin-bottom"><i class="fa fa-file-text-o"></i> Case Studies assigned to this {{ $unit->network_type()->first()->name }}</div>
		@if($unit->case_studies()->count())
			<section class="index-table-container">
				<table width="100%" class="index-table">
					<thead>
					<tr>
						<td width="5%">Year</td>
						<td width="10%" class="hide-m">Sector</td>
						<td width="30%" class="hide-m">Product(s)</td>
						<td width="25%" class="hide-m">AD at the time</td>
						<td width="35%">Background</td>
						<td width="10%"></td>

						@if($user->hasRole('Administrator'))
							<td colspan="3" class="hide-print">Actions</td>
						@endif

					</tr>
					</thead>
					<tbody>
					@foreach($unit->case_studies()->where('status', '=', 1)->orderBy('year', 'DESC')->get() as $case)
						<tr class="show-more__row" data-show-more-group="case-studies">
							<td>{{ $case->year }}</td>

							<td class="hide-m">{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</td>
							<td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>


							<td class="hide-m">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
							<td>{{ $case->name }} {{--Background--}} </td>
							<td width="10%"><a href="{{ route('cases.show', $case->id) }}">View</a></td>

							@if($user->hasRole('Administrator'))
								{{--Case approval/disapproval button based on status of case--}}
								@if( ! $case->status)
									<td class="actions hide-print content-center">
										{{ Form::open(['url' => array('cases/status_approve'), 'method' => 'get']) }}
										{{ Form::hidden('case_id', $case->id) }}
										<button type="submit" class="primary green-but"
												title="Approve this case study"><i class="fa fa-thumbs-up"></i>
										</button>
										{{ Form::close() }}
									</td>
								@else
									<td class="actions hide-print content-center">
										{{ Form::open(['url' => array('cases/status_disapprove'), 'method' => 'get']) }}
										{{ Form::hidden('case_id', $case->id) }}
										<button type="submit" class="primary orange-but"
												title="Disapprove this case study"><i class="fa fa-thumbs-down"></i>
										</button>
										{{ Form::close() }}
									</td>
								@endif
							@endif


							@if($user->hasRole('Administrator'))
								<td class="actions hide-print content-center">
									{{ Form::open(['route' => array('cases.edit', $case->id), 'method' => 'get']) }}
									<button type="submit" class="primary" title="Edit this case study"><i
												class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions hide-print content-center">
									{{ Form::open(['route' => array('cases.destroy', $case->id), 'method' => 'delete']) }}
									<button type="submit" class="red-but delete-row" data-resource-type="case study"
											title="Delete this case study"><i class="fa fa-times"></i></button>
									{{ Form::close() }}
								</td>
							@endif
						</tr>
					@endforeach
					</tbody>
				</table>
				<a href="#" class="secondary show-more__button" data-target-group="case-studies">Show more <i class="fa fa-caret-down"></i> </a>
			</section>
		@else
			@include('layouts.partials.index_no_records_found')
		@endif
	</div>
</div>

@stop