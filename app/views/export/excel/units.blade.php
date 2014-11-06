<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td rowspan="2">Unit Name</td>
			<td rowspan="2">Short Name</td>
			<td rowspan="2">Address</td>
			<td colspan="2">Clients</td>
			<td rowspan="2">Users</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $unit)
			<tr>
				<td>{{ $unit->name }}</td>
				<td>{{ $unit->short_name }}</td>
				<td>{{ $unit->addressOneLine() }}</td>
				<td>{{ number_format($unit->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td>{{ number_format($unit->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
				<td>{{ number_format($unit->users()->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>