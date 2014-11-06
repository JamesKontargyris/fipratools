<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td rowspan="2">Service Name</td>
			<td colspan="2">Clients</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $service)
			<tr>
				<td>{{ $service->name }}</td>
				<td>{{ number_format($service->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td>{{ number_format($service->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>