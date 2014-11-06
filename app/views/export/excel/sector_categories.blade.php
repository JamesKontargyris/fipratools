<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Sector Category Name</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $sector_category)
			<tr>
				<td>{{ $sector_category->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>