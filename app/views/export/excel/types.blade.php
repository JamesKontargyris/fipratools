<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td rowspan="2">Type Name</td>
			<td rowspan="2">ShortName</td>
			<td colspan="2">Clients</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $type)
			<tr>
				<td>{{ $type->name }}</td>
				<td>{{ $type->short_name }}</td>
				<td>{{ number_format($type->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td>{{ number_format($type->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>