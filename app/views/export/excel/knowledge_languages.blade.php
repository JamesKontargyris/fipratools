<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Language</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $language)
			<tr>
				<td>{{ $language->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>