@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="55%">Title</td>
			<td width="5%">Year</td>
			<td width="10%" class="hide-s">Unit</td>
			<td width="15%" class="hide-m">Sector(s)</td>
			<td width="15%" class="hide-m">Product(s)</td>
			<td width="10%" class="hide-m">AD</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $casestudy)
			<tr>
				<td><strong>{{ $casestudy->name }}</strong></td>
				<td><strong>{{ $casestudy->year }}</strong></td>
				<td><strong>{{ $casestudy->unit()->pluck('name') }}</strong></td>
				<td>{{ get_pretty_sector_names(unserialize($casestudy->sector_id)); }}</td>
				<td>{{ get_pretty_product_names(unserialize($casestudy->product_id)); }}</td>
				<td>{{ $casestudy->account_director()->pluck('first_name') }} {{ $casestudy->account_director()->pluck('last_name') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

