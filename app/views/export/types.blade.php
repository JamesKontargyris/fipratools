@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table class="index-table">
	<thead>
		<tr>
			<td rowspan="2" width="60%">Type Name</td>
			<td rowspan="2" width="20%">ShortName</td>
			<td colspan="2" width="20%" class="content-center">Clients</td>
		</tr>
		<tr>
			<td class="sub-header content-center">Active</td>
			<td class="sub-header content-center">Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $type)
			<tr>
				<td><strong>{{ $type->name }}</strong></td>
				<td>{{ $type->short_name }}</td>
				<td class="content-center">{{ number_format($type->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td class="content-center">{{ number_format($type->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

