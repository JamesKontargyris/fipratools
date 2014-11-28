@extends('layouts.status_check')

@section('page-header')
Client Status Check: {{ $user->unit()->pluck('name') }}
@stop

@section('content')
<section class="row">
	<div class="col-9">
		<h4>Please ensure the client status details listed below are correct. You can change any incorrect statuses using the client's corresponding dropdown box.</h4>
		<h5>Whether you have made changes or not, please confirm this listing using the button at the bottom of the page.</h5>
	</div>
</section>
<section class="row">
	<div class="col-9">
		{{ Form::open(['url' => 'statuscheck']) }}
		<table width="100%" class="index-table">
			<thead>
				<tr>
					<td>Client Name</td>
					<td class="actions">Status</td>
				</tr>
			</thead>
			<tbody style="font-size:14px">
				@foreach($clients as $client)
					<tr>
						<td><strong>{{ $client->name }}</strong></td>
						<td>
							{{ Form::select('clients[' . $client->id . ']',['1' => 'Active', '0' => 'Dormant'], $client->status) }}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</section>
<section class="row">
	<div class="col-9">
		{{ Form::submit('Confirm', ['class' => 'primary status-check-confirm']) }}
        {{ Form::close() }}
	</div>
</section>
@stop