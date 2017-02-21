@extends('layouts.master')

@section('page-header')
	@if(is_search())
		<i class="fa fa-search"></i> Searching for {{ Session::has('units.SearchType') ? Session::get('units.SearchType') : '' }}: {{ $items->search_term }}
	@else
		Network Members Overview
	@endif
@stop

@section('page-nav')
<li><a href="{{ route('units.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Member</a></li>
@if(section_is() == 'list')
	<li><a href="{{ route('unit_groups.index') }}" class="secondary"><i class="fa fa-pencil"></i> Manage Reporting Groups</a></li>
@endif
	<li><a href="{{ route('network_types.index') }}" class="secondary"><i class="fa fa-pencil"></i> Manage Network Types</a></li>
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
							<td rowspan="2" width="40%">Name</td>
							<td rowspan="2" width="10%">Short Name</td>
							<td rowspan="2" width="15%">Reporting Group</td>
							<td rowspan="2" width="15%" class="hide-m">Type</td>
							<td colspan="2" class="content-center hide-s">Clients</td>
							<td rowspan="2" width="5%" class="content-center hide-s">Users</td>
							<td rowspan="2" colspan="2" class="hide-print">Actions</td>
						</tr>
						<tr>
							<td class="sub-header content-center hide-s">Active</td>
							<td class="sub-header content-center hide-s">Dormant</td>
						</tr>

					</thead>
					<tbody>
						@foreach($items as $unit)
							<tr>
								<td><a href="{{ route('units.show', ['id' => $unit->id]) }}"><strong>{{ $unit->name }}</strong></a></td>
								<td>{{ $unit->short_name }}</td>
								<td class="hide-m">{{ $unit->unit_group_id ? $unit->unit_group()->first()->name : '-' }}</td>
								<td class="hide-m">{{ $unit->network_type_id ? $unit->network_type()->first()->name : '-' }}</td>
								<td class="content-center hide-s">{{ number_format($unit->clients()->where('status', '=', 1)->count(),0,'.',',') }}</td>
								<td class="content-center hide-s">{{ number_format($unit->clients()->where('status', '=', 0)->count(),0,'.',',') }}</td>
								<td class="content-center hide-s">{{ number_format($unit->users()->count(),0,'.',',') }}</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('units.edit', $unit->id), 'method' => 'get']) }}
										<button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('units.destroy', $unit->id), 'method' => 'delete']) }}
										<button type="submit" class="red-but delete-row" data-resource-type="Network Member"><i class="fa fa-times"></i></button>
									{{ Form::close() }}
								</td>
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