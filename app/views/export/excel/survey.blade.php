<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
	<tr>
		<td>Name</td>
		<td>Unit</td>
		<td>Expertise</td>
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
			<td>{{ $profile->getFullName() }}</td>
			<td>{{ $profile->unit()->first()->name }}</td>
			<td>{{ implode($user_expertise, ', ') }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
