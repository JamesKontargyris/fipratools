@extends('layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>
	@if(Session::get('clients.rowsHideShowDormant') == 'show')
		{{ $heading2 }}	– {{ number_format($active_count, 0)  }} active, {{ number_format($dormant_count, 0) }} dormant
	@else
		{{ str_replace('total', 'active', $heading2)  }}
	@endif
</h4>

<h5><span class="fa fa-asterisk turquoise">*</span> denotes mainly PR client. For all RLMFinsbury PR clients, please contact either Rory Chisholm or John Gray in the first instance except where indicated in brackets.</h5>

<table class="index-table">
	<thead>
		<tr>
			<td colspan="2" width="40%">Client name</td>
			<td width="10%">Sector</td>
			<td width="10%">Type</td>
			<td width="10%">Service</td>
			<td width="10%">Lead Unit</td>
			<td width="10%">AD to talk to</td>
			<td width="10%">Status</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $client)
			<tr>
				<td><strong>{{ $client->name }}</strong></td>
				<td class="client-links">
					@if($client->links()->count())
						<strong><i class="fa fa-link"></i> {{ $client->getLinkedUnitsList($client->id) }}</strong>
					@endif
				</td>
				<td>{{ $client->sector()->pluck('name') }}</td>
				<td>{{ $client->type()->pluck('short_name') }}</td>
				<td>{{ $client->service()->pluck('name') }}</td>
				<td><strong>{{ $client->unit()->pluck('name') }}</strong></td>
				<td>
					@if($client->pr_client)
						<span class="fa fa-asterisk turquoise">*</span>
						@if($client->account_director_id > 0)
							({{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }})
						@endif
					@else
						{{ $client->account_director()->pluck('first_name') }} {{ $client->account_director()->pluck('last_name') }}
					@endif
				</td>
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

