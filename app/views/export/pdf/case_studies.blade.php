@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="40%">Details</td>
			<td width="10%">Client</td>
			<td width="5%">Year</td>
			<td width="5%" class="hide-s">Unit</td>
			<td width="15%" class="hide-m">Sector(s)</td>
			<td width="10%" class="hide-m">Expertise Area(s)</td>
			<td width="15%" class="hide-m">Product(s)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $casestudy)
			<tr>
				<td>
					<strong>Background</strong><br>
                    {{ $casestudy->name }}<br><br>
                    <strong>Challenges facing client/Fipra</strong><br>
                    {{ $casestudy->challenges }}<br><br>
                    <strong>What Fipra did to overcome the challenges</strong><br>
                    {{ $casestudy->strategy }}<br><br>
                    <strong>End result</strong><br>
                    {{ $casestudy->result }}
				</td>
				<td>{{ ! $casestudy->client_id ? (! $casestudy->client ? 'Anonymous' : $casestudy->client) : $casestudy->client()->first()->name }}</td>
				<td><strong>{{ $casestudy->year }}</strong></td>
				<td><strong>{{ $casestudy->unit()->pluck('name') }}</strong></td>
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
@stop

