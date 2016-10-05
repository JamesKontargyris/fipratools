@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table class="index-table">
	<thead>
		<tr>
			<td rowspan="2" width="30%">Last Name</td>
			<td rowspan="2" width="30%">First Name</td>
			<td colspan="2" width="40%" class="content-center hide-s">Clients</td>
		</tr>
		<tr>
			<td class="sub-header content-center hide-s">Active</td>
			<td class="sub-header content-center hide-s">Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $ad)
			<tr>
				<td><strong>{{ $ad->last_name }}</strong></td>
				<td style="background-color: #ccd3e5;"><strong>{{ $ad->first_name }}</strong></td>
				<td class="content-center hide-s">{{ number_format($ad->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td class="content-center hide-s">{{ number_format($ad->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

