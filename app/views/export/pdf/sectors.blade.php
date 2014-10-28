@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table class="index-table">
	<thead>
		<tr>
			<td rowspan="2" width="55%">Sector Name</td>
			<td rowspan="2" width="25%" class="hide-m">Reporting Category</td>
			<td colspan="2" class="content-center hide-s">Clients</td>
		</tr>
		<tr>
			<td class="sub-header content-center hide-s">Active</td>
			<td class="sub-header content-center hide-s">Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $sector)
			<tr>
				<td><strong>{{ $sector->name }}</strong></td>
				<td class="hide-s">{{ $sector->category()->pluck('name') }}</td>
				<td class="content-center hide-s">{{ number_format($sector->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
				<td class="content-center hide-s">{{ number_format($sector->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

