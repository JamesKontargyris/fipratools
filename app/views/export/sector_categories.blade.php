@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="100%">Sector Category Name</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $sector_category)
			<tr>
				<td><strong>{{ $sector_category->name }}</strong></td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

