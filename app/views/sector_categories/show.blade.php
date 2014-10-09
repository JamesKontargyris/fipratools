@extends('layouts.master')

@section('page-header')
{{ $sector_category->name }}
@stop

@section('page-nav')
<li><a href="/sectors/{{ $sector_category->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this sector category</a></li>
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<section class="index-table-container">
	<div class="row">
		<div class="col-12">
			<table width="100%" class="index-table">
				<thead>
					<tr>
						<td width="55%">Sectors in this category</td>
					</tr>
				</thead>
				@if(count($sectors) > 0)
					<tbody>
						@foreach($sectors as $sector)
							<tr>
								<td><strong><a href="#">{{ $sector->name }}</a></strong></td>
							</tr>
						@endforeach
					</tbody>
				@else
					<tr><td>No records found.</td></tr>
				@endif
			</table>
		</div>
	</div>
</section>
@stop