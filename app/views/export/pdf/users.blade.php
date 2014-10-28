@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table class="index-table">
	<thead>
		<tr>
			<td rowspan="2" width="55%">User</td>
			<td rowspan="2" width="10%" class="content-center hide-s">Role</td>
			<td colspan="2" width="10%" class="content-center hide-s">Clients Added</td>
		</tr>
		<tr>
			<td class="sub-header content-center hide-s">Active</td>
			<td class="sub-header content-center hide-s">Dormant</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $list_user)
			<tr>
				<td><strong>
					@if(Session::get ('users.rowsNameOrder') == 'last_first')
						{{ $list_user->getFullName(true) }}
					@else
						{{ $list_user->getFullName(false) }}
					@endif
					</strong></td>
				<td class="content-center hide-s">{{ $list_user->roles()->pluck('name') }}</td>
				<td class="content-center hide-s">{{ number_format($list_user->clients()->where('status', '=', 1)->count(),0,0,',') }}</td>
				<td class="content-center hide-s">{{ number_format($list_user->clients()->where('status', '=', 0)->count(),0,0,',') }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

