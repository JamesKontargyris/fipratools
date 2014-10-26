@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table class="index-table">
	<thead>
		<tr>
			<td rowspan="2" width="40%">Unit Name</td>
			<td rowspan="2" width="10%">Short Name</td>
			<td rowspan="2" width="30%">Address</td>
			<td colspan="2" class="content-center">Clients</td>
			<td rowspan="2" width="5%" class="content-center">Users</td>
		</tr>
		<tr>
			<td class="sub-header content-center hide-s">Active</td>
			<td class="sub-header content-center hide-s">Dormant</td>
		</tr>

	</thead>
	<tbody>
		@foreach($items as $unit)
			<tr>
				<td><strong>{{ $unit->name }}</strong></td>
				<td>{{ $unit->short_name }}</td>
				<td class="hide-m">{{ $unit->addressOneLine() }}</td>
				<td class="content-center">{{ number_format($unit->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td class="content-center">{{ number_format($unit->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
				<td class="content-center">{{ number_format($unit->users()->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

