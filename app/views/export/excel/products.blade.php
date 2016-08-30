<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Product Name</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $product)
			<tr>
				<td>{{ $product->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>