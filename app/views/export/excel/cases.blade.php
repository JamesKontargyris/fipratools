<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
	<tr>
		<td>Client where disclosable</td>
		<td>Year</td>
		<td>Background</td>
		@if($user->hasRole('Administrator'))
			<td>Unit</td>
		@endif
		<td>Sector(s)</td>
		<td>Expertise Area(s)</td>
		<td>Product(s)</td>
		<td>AD at the time</td>
		<td>Status</td>
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
			<td>
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
					{{ implode(array_unique($expertiseAreas), ' &bull; ') }}
				@endif
			</td>
			<td>{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
			<td>{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
			<td>{{ ! $case->status ? '<span class="status--pending">Pending</span>' : '<span class="status--active">Active</span>'}}</td>
		</tr>
	@endforeach
	</tbody>
</table>