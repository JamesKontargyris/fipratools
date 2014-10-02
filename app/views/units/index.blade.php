@extends('layouts.master')

@section('content')
@include('layouts.partials.messages')

<section id="page-header" class="col-12">
	<h2>All Units</h2>
	<a href="#" class="page-menu-icon-s">
		<i class="fa fa-2x fa-navicon"></i>
	</a>
	<nav>
		<ul>
			<li><a href="{{ route('unit.create') }}"><i class="fa fa-plus-circle"></i> Add a new unit</a></li>
			<li><a href="{{ route('unit.create') }}"><i class="fa fa-plus-circle"></i> Add a new unit</a></li>
		</ul>
	</nav>
</section>

<section class="filter-container col-12">
	<div class="row highlight">
		<div class="col-6">
			Viewing units <strong>{{ $units->getFrom() }}-{{ $units->getTo() }}</strong> of <strong>{{ $units->getTotal() }}</strong>
		</div>
		<div class="col-6 last filter-search">
			{{ Form::open(['url' => 'unit.search']) }}
				{{ Form::text('search', Input::old('search'), ['placeholder' => 'Search...']) }}
				<button><i class="fa fa-search"></i></button>
			{{ Form::close() }}
		</div>
	</div>
	<div class="filters">
		<ul>
			<li>@include('layouts.partials.filters.rows_to_view')</li>
			<li>@include('layouts.partials.filters.rows_sort_order')</li>
			<li><a href="?reset_filters=yes" class="filter-but">Reset Filters</a></li>
		</ul>
	</div>
	<a class="filter-menu-icon-s" href="#"><i class="fa fa-filter"></i> Filter</a>
</section>

<section class="col-12">

<div class="hide-s">
	{{ $units->links() }}
</div>
	<table width="100%" class="index-table">
		<thead>
			<tr>
				<td width="70%">Unit Name</td>
				<td width="15%" class="content-center hide-s">Clients</td>
				<td width="15%" class="content-center hide-s">Users</td>
				<td class="content-right">Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach($units as $unit)
				<tr>
					<td><a href="{{ route('unit.show', ['id' => $unit->id]) }}"><strong>{{ $unit->name }}</strong></a></td>
					<td class="content-center hide-s">{{ number_format(23,0,'.',',') }}</td>
					<td class="content-center hide-s">{{ number_format(8,0,'.',',') }}</td>
					<td class="actions content-right">
						<a href="{{ route('unit.edit', ['id' => $unit->id]) }}" class="primary"><i class="fa fa-pencil"></i></a>
						<a href="{{ route('unit.destroy', ['id' => $unit->id]) }}" class="red-but"><i class="fa fa-times"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<section class="pagination-container">
		{{ $units->links() }}
	</section>
</section>
@stop