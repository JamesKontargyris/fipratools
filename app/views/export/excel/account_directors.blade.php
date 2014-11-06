<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td rowspan="2">Last Name</td>
			<td rowspan="2">First Name</td>
			<td colspan="2">Clients</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $ad)
			<tr>
				<td>{{ $ad->last_name }}</td>
				<td>{{ $ad->first_name }}</td>
				<td>{{ number_format($ad->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td>{{ number_format($ad->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
