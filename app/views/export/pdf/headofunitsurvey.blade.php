@extends('......layouts.pdf')

@section('content')
<h1>{{ $heading1 }}</h1>
<h4>{{ $heading2 }}</h4>

<table width="100%" class="index-table">
	<thead>
	<tr>
		<td width="40%">Name</td>
		<td width="40%">Unit</td>
		<td width="10%">Sections Completed</td>
		<td width="10%">Answers Given</td>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $profile)
		<tr>
			<td><strong>{{ $profile->getFullName() }}</strong></td>
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
			<td
				@if($answers_count <= 20 )
				style="background-color:#ffc3c5"
				@elseif($answers_count > 20 && $answers_count <= 34)
				style="background-color:#ffd8a6"
				@else
				style="background-color:#ddffa1"
				@endif
			>{{ $answers_count }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop

