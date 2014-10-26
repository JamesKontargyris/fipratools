@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table class="index-table">
	<thead>
		<tr>
			<td>Client name</td>
			@if($user->hasRole('Administrator'))
				<td>Unit</td>
			@endif
			<td>Sector</td>
			<td>Type</td>
			<td>Service</td>
			<td>Status</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $client)
			<tr>
				<td><strong>{{ $client->name }}</strong></td>

				@if($user->hasRole('Administrator'))
					<td><strong>{{ $client->unit()->pluck('name') }}</strong></td>
				@endif

				<td>{{ $client->sector()->pluck('name') }}</td>
				<td>{{ $client->type()->pluck('short_name') }}</td>
				<td>{{ $client->service()->pluck('name') }}</td>
				@if($client->status)
					<td class="status-active">Active</td>
				@else
					<td class="status-dormant">Dormant</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>
@stop

