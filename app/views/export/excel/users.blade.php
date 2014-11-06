<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td rowspan="2">User</td>
			<td rowspan="2">Role</td>
			<td colspan="2">Clients Added</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $list_user)
			<tr>
				<td>
					@if(Session::get ('users.rowsNameOrder') == 'last_first')
						{{ $list_user->getFullName(true) }}
					@else
						{{ $list_user->getFullName(false) }}
					@endif
				</td>
				<td>{{ $list_user->roles()->pluck('name') }}</td>
				<td>{{ number_format($list_user->clients()->where('status', '=', 1)->count(),0,0,',') }}</td>
				<td>{{ number_format($list_user->clients()->where('status', '=', 0)->count(),0,0,',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>