@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="50%">Background</td>
			<td width="10%">Year</td>
			<td width="10%" class="hide-m">Sector(s)</td>
			<td width="10%" class="hide-m">Product(s)</td>
		@if($user->hasRole('Administrator'))
				<td width="10%" class="hide-s">Unit</td>
			@endif
			<td width="10%">AD</td>
			<td width="10%">Client</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $casestudy)
			<tr>
				<td><strong>{{ $casestudy->name }}</strong></td>
				<td>{{ $casestudy->year }}</td>
				<td>{{ get_pretty_sector_names(unserialize($casestudy->sector_id)); }}</td>
				<td>{{ get_pretty_product_names(unserialize($casestudy->product_id)); }}</td>
			@if($user->hasRole('Administrator'))
					<td>{{ $casestudy->unit()->pluck('name') }}</td>
				@endif
				<td>{{ $casestudy->account_director()->pluck('first_name') }} {{ $casestudy->account_director()->pluck('last_name') }}</td>
				<td>{{ ($casestudy->client) ? $casestudy->client : 'Anonymous' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

