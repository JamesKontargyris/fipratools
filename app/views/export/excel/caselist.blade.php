<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
	<tr>
		<td>Background</td>
		<td>Challenges facing client/Fipra</td>
		<td>What Fipra did to overcome the challenges</td>
		<td>Result</td>
		<td>Client</td>
		<td>Year</td>
		<td>Unit</td>
		<td>Sector(s)</td>
		<td>Expertise Area(s)</td>
		<td>Product(s)</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $casestudy)
		<tr>
			<td>{{ $casestudy->name }}</td>
			<td>{{ $casestudy->challenges }}</td>
			<td>{{ $casestudy->strategy }}</td>
			<td>{{ $casestudy->result }}</td>
			<td>{{ ! $casestudy->client_id ? (! $casestudy->client ? 'Anonymous' : $casestudy->client) : $casestudy->client()->first()->name }}</td>
			<td>{{ $casestudy->year }}</td>
			<td>{{ $casestudy->unit()->pluck('name') }}</td>
			<td>{{ get_pretty_sector_names(unserialize($casestudy->sector_id)); }}</td>
			<td>
				<?php
				// Get the expertise areas (called Sector Areas here) that are associated with each sector
				$sectors = unserialize($casestudy->sector_id);
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
			<td>{{ get_pretty_product_names(unserialize($casestudy->product_id)); }}</td>
		</tr>
	@endforeach
	</tbody>
</table>