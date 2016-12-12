<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
		<tr>
			<td>Name</td>
			<td>Group</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $area)
			<tr>
				<td>{{ $area->name }}</td>
				<td>{{ KnowledgeAreaGroup::find($area->knowledge_area_group_id)->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>