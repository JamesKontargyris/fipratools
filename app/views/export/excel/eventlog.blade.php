<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Event</td>
			<td>User</td>
			<td>When (CET)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $log)
			<tr>
				<td>{{ $log->event }}</td>
				<td>@if($log->user_name){{ $log->user_name }}@endif @if($log->unit_name)({{ $log->unit_name }})@endif</td>
				<td>{{ date('d F Y \a\t g.ia', strtotime($log->created_at)) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>