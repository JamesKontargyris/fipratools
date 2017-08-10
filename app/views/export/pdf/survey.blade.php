@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
	<tr>
		<td width="20%">Name</td>
		<td width="20%">Unit</td>
		<td width="60%">Expertise</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $profile)
		<?php
		/*Get user expertise with a score of 4 or 5*/
		$user_expertise = $profile->knowledge_areas()->where('score', '=', 4)->orWhere('score', '=', 5)->get()->lists('name');
		/* Get user language(s) and fluency data*/
		$user_languages = [];
		?>
		<tr>
			<td><strong>{{ $profile->getFullName() }}</strong></td>
			<td>{{ $profile->unit()->first()->name }}</td>
			<td>{{ implode($user_expertise, ', ') }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop

