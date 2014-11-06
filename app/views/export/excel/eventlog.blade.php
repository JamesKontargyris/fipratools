<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td width="45%">Event</td>
			<td width="15%">User</td>
			<td width="15%">Unit</td>
			<td width="25%">When (CET)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $log)
			<tr>
				<td><strong>{{ $log->event }}</strong></td>
				<td>{{ $log->user_name }}</td>
				<td>{{ $log->unit_name }}</td>
				<td>{{ date('d F Y \a\t g.ia', strtotime($log->created_at)) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>