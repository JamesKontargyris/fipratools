@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="60%">Title</td>
			@if($user->hasRole('Administrator'))
				<td width="10%" class="hide-s">Unit</td>
			@endif
			<td width="15%" class="hide-m">Sector</td>
			<td width="15%" class="hide-m">Product(s)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $casestudy)
			<tr>
				<td><strong>{{ $casestudy->name }}</strong></td>

				@if($user->hasRole('Administrator'))
					<td><strong>{{ $casestudy->unit()->pluck('name') }}</strong></td>
				@endif

				<td>{{ $casestudy->sector()->pluck('name') }}</td>
				<td>{{ get_pretty_product_names(unserialize($casestudy->product_id)); }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

