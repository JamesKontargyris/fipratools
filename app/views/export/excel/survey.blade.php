<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
	<tr>
		<td>Name</td>
		<td>Unit</td>
		<td>Expertise</td>
		<td>Languages</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $profile)
		<?php
		/*Get user expertise with a score of 4 or 5*/
		$user_expertise = $profile->knowledge_areas()->where('score', '=', 4)->orWhere('score', '=', 5)->get()->lists('name');
		/* Get user language(s) and fluency data*/
		$user_languages = [];
		$languages = $profile->knowledge_languages()->get()->toArray();
		foreach($languages as $language) {
			$user_languages[] = $language['pivot']['fluent'] ? '<strong>' . $language['name'] . ' (fluent)</strong>' : $language['name'];
		}
		?>
		<tr>
			<td>{{ $profile->getFullName() }}</td>
			<td>{{ $profile->unit()->first()->name }}</td>
			<td>{{ implode($user_expertise, ', ') }}</td>
			<td>{{ implode($user_languages, ', ') }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
