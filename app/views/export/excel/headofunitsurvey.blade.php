<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table>
	<thead>
	<tr>
		<td>Name</td>
		<td>Unit</td>
		<td>Sections Completed</td>
		<td>Answers Given</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $profile)
		<tr>
			<td>{{ $profile->getFullName() }}</td>
			<td>
				@if(isset($profile->unit()->first()->id)){{ $profile->unit()->first()->name }}@endif
			</td>
			<td>
				<?php
				$sections_completed_count = 0;
				?>

				@foreach($additional_data['section_names'] as $section_name)
					@if(Leadofficelist\Knowledge_data\KnowledgeData::sectionIsComplete($additional_data['sections'], $section_name, $profile->id))
						<?php $sections_completed_count++; ?>
					@endif
				@endforeach

				&nbsp;&nbsp;{{ $sections_completed_count }} of 6

			</td>
			<?php $answers_count = Leadofficelist\Knowledge_data\KnowledgeData::where('user_id', '=', $profile->id)->where('survey_name', '=', 'head_of_unit_survey')->count(); ?>
			<td>{{ $answers_count }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
