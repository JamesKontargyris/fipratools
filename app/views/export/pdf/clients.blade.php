@extends('......layouts.pdf')

@section('content')
<h1>
	{{ $heading1 }}
</h1>
<h4>
	@if(isset($heading2)) {{ $heading2 }} @endif
	@if(Session::get('clients.rowsHideShowActive') == 'show' && isset($active_count))
		{{ number_format($active_count, 0)  }} active clients
	@endif
	@if(Session::get('clients.rowsHideShowActive') == 'show' && Session::get('clients.rowsHideShowDormant') == 'show' && isset($active_count) && isset($dormant_count))
		|
	@endif
	@if(Session::get('clients.rowsHideShowDormant') == 'show' && isset($dormant_count))
		{{ number_format($dormant_count, 0)  }} dormant clients
	@endif
</h4>

<table class="index-table">
	<thead>
		<tr>
			<td>Client name</td>
			@if($user->hasRole('Administrator'))
				<td>Lead Network Member</td>
			@endif
			<td>Sector</td>
			<td>Type</td>
			<td>Service</td>
			@if($key == 'list')
				<td>AD</td>
				<td>Comments</td>
			@endif
			@if(Session::get('list.rowsHideShowDormant') == 'show' || Session::get('list.rowsHideShowActive') == 'show')
				<td width="10%">Status</td>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($items as $client)
			<tr>
				<td><strong>{{ $client->name }}</strong></td>

				@if($user->hasRole('Administrator'))
					<td>{{ $client->unit()->pluck('name') }}</td>
				@endif

				<td>{{ $client->sector()->pluck('name') }}</td>
				<td>{{ $client->type()->pluck('short_name') }}</td>
				<td>{{ $client->service()->pluck('name') }}</td>
				@if($key == 'list')
					<td>{{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}</td>
					<td>{{ $client->comments }}</td>
				@endif
				@if(Session::get('list.rowsHideShowDormant') == 'show' || Session::get('list.rowsHideShowActive') == 'show')
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
@stop

