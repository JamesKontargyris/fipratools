@extends('layouts.master')

@section('page-header')
{{ $show_user->getFullName() }} ({{ $show_user->unit()->pluck('name') }})
@stop

@section('page-nav')
@if($user->can('manage_users'))
	<li><a href="/users/{{ $show_user->id }}/edit" class="secondary"><i class="fa fa-pencil"></i> Edit this user</a></li>
@endif
@stop

@section('content')

@include('layouts.partials.back_button')

@include('layouts.partials.messages')

<div class="row">
	<div class="col-6">
	</div>
</div>

{{--@if(count($clients) > 0)--}}

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td width="55%">Clients added by this user</td>
						</tr>
					</thead>
					<tbody>
						{{--@foreach($clients as $client)--}}
							{{--<tr>--}}
								{{--<td><strong><a href="#">{{ $client['name'] }}</a></strong></td>--}}
							{{--</tr>--}}
						{{--@endforeach--}}
					</tbody>
				</table>
			</div>
		</div>
	</section>
{{--@else--}}
	{{--@include('layouts.partials.index_no_records_found')--}}
{{--@endif--}}
@stop