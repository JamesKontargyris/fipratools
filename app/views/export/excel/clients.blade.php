<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Client name</td>
			@if($user->hasRole('Administrator'))
				<td>Unit</td>
			@endif
			<td>Sector</td>
			<td>Type</td>
			<td>Service</td>
			@if(Session::get('list.rowsHideShowDormant') == 'show')
				<td width="10%">Status</td>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($items as $client)
			<tr>
				<td>{{ $client->name }}</td>

				@if($user->hasRole('Administrator'))
					<td>{{ $client->unit()->pluck('name') }}</td>
				@endif

				<td>{{ $client->sector()->pluck('name') }}</td>
				<td>{{ $client->type()->pluck('short_name') }}</td>
				<td>{{ $client->service()->pluck('name') }}</td>
				@if(Session::get('list.rowsHideShowDormant') == 'show')
					@if($client->status)
						<td class="status-active">Active</td>
					@else
						<td class="status-dormant">Dormant</td>
					@endif
				@endif
			</tr>
		@endforeach
	</tbody>
</table>