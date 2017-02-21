@extends('layouts.master')

@section('page-header')
	@if(is_search())
		<i class="fa fa-search"></i> Searching for {{ Session::has('sectors.SearchType') ? Session::get('sectors.SearchType') : '' }}: {{ $items->search_term }}
	@else
		Sectors Overview
	@endif
@stop

@section('page-nav')
<li><a href="{{ route('sectors.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Sector</a></li>
<li><a href="{{ route('sector_categories.index') }}" class="secondary"><i class="fa fa-pencil"></i> Manage Reporting Categories</a></li>
@stop

@section('export-nav')
@stop

@section('content')

@include('layouts.partials.messages')

@if(count($items) > 0)
	@include('layouts.partials.rows_nav')

	@include('layouts.partials.filters')

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td rowspan="2" width="55%">Sector Name</td>
							<td rowspan="2" width="25%" class="hide-m">Reporting Category</td>
							<td colspan="2" class="content-center hide-s">Clients</td>
							<td rowspan="2" colspan="2" class="hide-print">Actions</td>
						</tr>
						<tr>
							<td class="sub-header content-center hide-s">Active</td>
							<td class="sub-header content-center hide-s">Dormant</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $sector)
							<tr>
								<td><strong><a href="{{ route('sectors.show', ['id' => $sector->id]) }}">{{ $sector->name }}</a></strong></td>
								<td class="hide-s">{{ $sector->category()->pluck('name') }}</td>
								<td class="content-center hide-s">{{ number_format($sector->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
								<td class="content-center hide-s">{{ number_format($sector->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('sectors.edit', $sector->id), 'method' => 'get']) }}
										<button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('sectors.destroy', $sector->id), 'method' => 'delete']) }}
										<button type="submit" class="red-but delete-row" data-resource-type="sector"><i class="fa fa-times"></i></button>
									{{ Form::close() }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>

	@include('layouts.partials.pagination_container')
@else
	@include('layouts.partials.index_no_records_found')
@endif
@stop