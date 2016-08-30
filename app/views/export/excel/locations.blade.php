<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Location Name</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $location)
			<tr>
				<td>{{ $location->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>