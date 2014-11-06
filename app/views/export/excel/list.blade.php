<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<h5>* denotes mainly PR client. For all RLMFinsbury PR clients, please contact either Rory Chisholm or John Gray in the first instance except where indicated in brackets.</h5>

<table>
	<thead>
		<tr>
			<td>Client name</td>
			<td>Sector</td>
			<td>Type</td>
			<td>Service</td>
			<td>Lead Unit</td>
			<td>AD</td>
			<td>Comments</td>
			@if(Session::get('list.rowsHideShowDormant') == 'show')
				<td>Status</td>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($items as $client)
			<tr>
				<td>{{ $client->name }}</td>
				<td>{{ $client->sector()->pluck('name') }}</td>
				<td>{{ $client->type()->pluck('short_name') }}</td>
				<td>{{ $client->service()->pluck('name') }}</td>
				<td>{{ $client->unit()->pluck('name') }}</td>
				<td>
					@if($client->pr_client)
						*
						@if($client->account_director_id > 0)
							({{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }})
						@endif
					@else
						{{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
					@endif
				</td>
				<td>{{ $client->comments }}</td>
				@if(Session::get('list.rowsHideShowDormant') == 'show')
					@if($client->status)
						<td>Active</td>
					@else
						<td>Dormant</td>
					@endif
				@endif
			</tr>
		@endforeach
	</tbody>
</table>