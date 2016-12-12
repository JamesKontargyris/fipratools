@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
		<tr>
			<td width="65%">Name</td>
			<td width="35%">Group</td>
		</tr>
	</thead>
	<tbody>
		@foreach($items as $area)
			<tr>
				<td><strong>{{ $area->name }}</strong></td>
				<td>{{ KnowledgeAreaGroup::find($area->knowledge_area_group_id)->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@stop

