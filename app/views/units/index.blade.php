@extends('layouts.master')

@section('page-header')
@if(is_search()) Searching for: {{ $items->search_term }} @else Units Overview @endif
@stop

@section('page-nav')
<li><a href="{{ route('units.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Unit</a></li>
@stop

@section('content')

@include('layouts.partials.messages')

@if(count($items) > 0)
	<section class="rows-nav-container row no-margin">
		<div class="col-12">
			<ul class="rows-nav">
				@if($items->links() != '')
					<li class="hide-s">
						{{ $items->links() }}
					</li>
				@endif
				<li>Viewing <strong>{{ $items->getFrom() }}-{{ $items->getTo() }}</strong> of <strong>{{ $items->getTotal() }}</strong></li>
				<li class="hide-m">Page {{ str_replace('Page ', '', $items->getCurrentPage()) }} of {{ str_replace('Page ', '', $items->getLastPage()) }}</li>
				<li class="search-container">
					{{ Form::open(['url' => 'units/search']) }}
						{{ Form::text('search', null, ['placeholder' => 'Search...']) }}
						<button type="submit" class="search-but"><i class="fa fa-search"></i></button>
					{{ Form::close() }}
				</li>
				@if(is_search())
					<li><a href="{{ route('units.index') }}" class="primary clear-search-but"><i class="fa fa-times"></i> Clear Search</a></li>
				@endif
			</ul>
		</div>
	</section>

	<section class="row no-margin">
		<div class="col-12 filter-container">
			<a class="filter-menu-icon-m" href="#">Filters</a>
			<div class="col-12 filters">
				<ul>
					<li>@include('layouts.partials.filters.rows_to_view')</li>
					<li>@include('layouts.partials.filters.rows_sort_order')</li>
					<li><a href="?reset_filters=yes" class="filter-but">Reset Filters</a></li>
				</ul>
			</div>
		</div>
	</section>

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td width="55%">Unit Name</td>
							<td width="25%" class="hide-m">Address</td>
							<td width="10%" class="content-center hide-s">Clients</td>
							<td width="10%" class="content-center hide-s">Users</td>
							<td colspan="2">Actions</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $unit)
							<tr>
								<td><a href="{{ route('units.show', ['id' => $unit->id]) }}"><strong>{{ $unit->name }}</strong></a></td>
								<td class="hide-m">{{ $unit->addressOneLine() }}</td>
								<td class="content-center hide-s">{{ number_format(0,0,'.',',') }}</td>
								<td class="content-center hide-s">{{ number_format(0,0,'.',',') }}</td>
								<td class="actions content-right">
									{{ Form::open(['route' => array('units.edit', $unit->id), 'method' => 'get']) }}
										<button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right">
									{{ Form::open(['route' => array('units.destroy', $unit->id), 'method' => 'delete']) }}
										<button type="submit" class="red-but delete-row" data-resource-type="unit"><i class="fa fa-times"></i></button>
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

	<section class="pagination-container">
		@if($items->links() != '')
			<div class="row">
				<div class="col-12">
					{{ $items->links() }}
				</div>
			</div>
		@endif
	</section>
@else
	<div class="row">
		<div class="col-12">
			<p>No records found.</p>
			@if(is_search())
				<a class="primary" href="{{ route('units.index') }}"><i class="fa fa-caret-left"></i> Back to overview</a>
			@endif
		</div>
	</div>
@endif
@stop