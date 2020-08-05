@extends('......layouts.pdf')

@section('page-header')
About the Lead Office List
@stop

@section('content')
	<div style="padding: 10px; margin-bottom:10px; background-color: #efefef;">
		<table width="100%">
			<tr>
				<td>
					<h2>About the Lead Office List</h2>
				</td>
			</tr>
		</table>
	</div>

<?php
    $content = (string) get_widget('lol_about_us');

    $columnContent = ContentToTwoColumns($content);
?>

<div style="width:48%; float:left; font-size:10px; line-height:1.6">
    {{ $columnContent[0] }}
</div>
<div style="width:48%; float:right; font-size:10px; line-height:1.6">
    {{ $columnContent[1] }}
</div>
@stop