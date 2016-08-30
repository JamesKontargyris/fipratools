<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
	<tr>
		<td>Title</td>
		<td>Year</td>
		@if($user->hasRole('Administrator'))
			<td>Unit</td>
		@endif
		<td>Sector</td>
		<td>Product(s)</td>
		<td>Location</td>
		<td>AD</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $casestudy)
		<tr>
			<td>{{ $casestudy->name }}</td>
			<td>{{ $casestudy->year }}</td>

			@if($user->hasRole('Administrator'))
				<td>{{ $casestudy->unit()->pluck('name') }}</td>
			@endif

			<td>{{ $casestudy->sector()->pluck('name') }}</td>
			<td>{{ get_pretty_product_names(unserialize($casestudy->product_id)); }}</td>
			<td>{{ $casestudy->location()->pluck('name') }}</td>
			<td>{{ $casestudy->account_director()->pluck('first_name') }} {{ $casestudy->account_director()->pluck('last_name') }}</td>
		</tr>
	@endforeach
	</tbody>
</table>