<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Name</td>
			<td>Order</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $group)
			<tr>
				<td>{{ $group->name }}</td>
				<td>{{ $group->order }}</td>
			</tr>
		@endforeach
	</tbody>
</table>