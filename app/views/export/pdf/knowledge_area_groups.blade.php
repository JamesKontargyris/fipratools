@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="80%">Name</td>
			<td width="20%">Order</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $group)
			<tr>
				<td><strong>{{ $group->name }}</strong></td>
				<td>{{ $group->order }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

