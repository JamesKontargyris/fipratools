@extends('......layouts.pdf')

@section('content')
<h1>Event Log @if(Input::has('filetype') && Input::get('filetype') == 'pdf_selection') Selection @endif</h1>

<h4><em>Times shown are CET.</em></h4>
<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="45%">Event</td>
			<td width="35%">User</td>
			<td width="20%">When (CET)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $log)
			<tr>
				<td><strong>{{ $log->event }}</strong></td>
				<td>@if($log->user_name){{ $log->user_name }}@endif @if($log->unit_name)({{ $log->unit_name }})@endif</td>
				<td>{{ date('d M Y \a\t g.ia', strtotime($log->created_at)) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop