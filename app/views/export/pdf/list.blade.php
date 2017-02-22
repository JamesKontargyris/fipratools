@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>
    {{-- This is a selection if no active_count or dormant_count variables have been passed in--}}
    @if(! isset($active_count) && ! isset($dormant_count))  {{ $heading2 }} @endif

    {{--Display a meaningful title depending on the active, dormant or combo of active/dormant clients that is showing--}}
	@if(Session::get('list.rowsHideShowActive') == 'show' && isset($active_count))
        {{ number_format($active_count, 0)  }} active clients
	@endif
	@if(Session::get('list.rowsHideShowActive') == 'show' && Session::get('list.rowsHideShowDormant') == 'show' && isset($active_count) && isset($dormant_count))
		|
	@endif
    @if(Session::get('list.rowsHideShowDormant') == 'show' && isset($dormant_count))
        {{ number_format($dormant_count, 0)  }} dormant clients
    @endif
</h4>

<div style="font-weight:bold; text-align: center; font-style: italic;">
	{{ nl2br(get_widget('lead_office_list_details')) }}
</div>

<table class="index-table">
	<thead>
		<tr>
			<td  width="35%">Client name</td>
			<td width="5%">Unit links</td>
			<td width="10%">Sector</td>
			<td width="5%">Type</td>
			<td width="5%">Service</td>
			<td width="10%">Lead Network Member</td>
			<td width="10%">AD</td>
			<td width="15%">Comments</td>
            <td width="5%">Status</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $client)
			<tr>
				<td><strong>{{ $client->name }}</strong></td>
				<td class="client-links" style="background-color: #ccd3e5;">
					@if($client->links()->count())
						<strong><i class="fa fa-link"></i> {{ $client->getLinkedUnitsList($client->id) }}</strong>
					@endif
				</td>
				<td>{{ $client->sector()->pluck('name') }}</td>
				<td>{{ $client->type()->pluck('short_name') }}</td>
				<td>{{ $client->service()->pluck('name') }}</td>
				<td>{{ $client->unit()->pluck('name') }}</td>
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
				<td>{{ $client->comments }}</td>
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

