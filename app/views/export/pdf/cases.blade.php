@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
	<tr>
		<td width="10%">Client where disclosable</td>
		<td width="5%">Year</td>
		<td width="25%">Background</td>
		@if($user->hasRole('Administrator'))
			<td width="10%">Unit</td>
		@endif
		<td width="15%">Sector(s)</td>
		<td width="15%">Expertise Area(s)</td>
		<td width="20%">Product(s)</td>
		<td width="10%">AD at the time</td>
		<td width="10%">Status</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $case)
		<tr>
			<td>{{ ! $case->client_id ? (! $case->client ? 'Anonymous' : $case->client) : '<a
                                            href="' . route('clients.show', $case->client()->first()->id) . '"><strong>' . $case->client()->first()->name . '</strong></a>' }}</td>
			<td>{{ $case->year }}</td>
			<td>{{ $case->name }} {{--Background--}} </td>
			@if($user->hasRole('Administrator'))
				<td>{{ $case->unit()->pluck('name') }}</td>
			@endif
			<td>{{ get_pretty_sector_names(unserialize($case->sector_id)); }}</td>
			<td class="hide-m expertise-field">
				<?php
				// Get the expertise areas (called Sector Areas here) that are associated with each sector
				$sectors = unserialize($case->sector_id);
				$expertiseAreas = [];
				foreach($sectors as $sector) {
					if($sectorObj = \Leadofficelist\Sectors\Sector::find($sector)) {
						$expertiseAreas[] = \Leadofficelist\Sector_categories\Sector_category::find($sectorObj->category_id)['name'];
					}
				}
				?>

				@if($expertiseAreas)
					<div class="expertise-field__text-container">
						{{ implode(array_unique($expertiseAreas), ' &bull; ') }}
						<i class="fa fa-caret-left fa-lg expertise-field__pointer"></i>
					</div>
				@endif
			</td>
			<td>{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
			<td>{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
			<td>{{ ! $case->status ? '<span class="status--pending">Pending</span>' : '<span class="status--active">Active</span>'}}</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop

