@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
	<tr>
		<td width="40%">Name</td>
		<td width="20%">Unit</td>
		<td width="20%">Expertise</td>
		<td width="20%">Languages</td>
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
			<td><strong>{{ $profile->getFullName() }}</strong></td>
			<td>{{ $profile->unit()->first()->name }}</td>
			<td>{{ implode($user_expertise, ', ') }}</td>
			<td>{{ implode($user_languages, ', ') }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop

