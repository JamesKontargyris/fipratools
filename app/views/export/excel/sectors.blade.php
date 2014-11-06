<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td rowspan="2">Sector Name</td>
			<td rowspan="2">Reporting Category</td>
			<td colspan="2">Clients</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $sector)
			<tr>
				<td>{{ $sector->name }}</td>
				<td>{{ $sector->category()->pluck('name') }}</td>
				<td>{{ number_format($sector->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td>{{ number_format($sector->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>