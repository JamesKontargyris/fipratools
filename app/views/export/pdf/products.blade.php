@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td rowspan="2" width="100%">Product Name</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $product)
			<tr>
				<td><strong>{{ $product->name }}</strong></td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

