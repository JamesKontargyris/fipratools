@extends('layouts.master')

@section('page-header')
{{ $type->name }}
@stop

@section('page-nav')
<li><a href="/types/{{ $type->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this type</a></li>
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

@if(count($clients) > 0)

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td width="55%">Active clients in this type</td>
						</tr>
					</thead>
					<tbody>
						@foreach($clients as $client)
							<tr>
								<td><strong><a href="#">{{ $client['name'] }}</a></strong></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>
@else
	@include('layouts.partials.index_no_records_found')
@endif
@stop