@extends('layouts.master')

@section('page-header')
	@if(is_search())
		<i class="fa fa-search"></i> Searching for {{ Session::has('sector_categories.SearchType') ? Session::get('sector_categories.SearchType') : '' }}: {{ $items->search_term }}
	@else
		Sector Categories Overview
	@endif
@stop

@section('page-nav')
<li><a href="{{ route('sectors.index') }}" class="secondary"><i class="fa fa-caret-left"></i> Sectors Overview</a></li>
<li><a href="{{ route('sector_categories.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Sector Reporting Category</a></li>
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
							<td width="100%">Sector Category Name</td>
							<td colspan="2" class="hide-print">Actions</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $sector_category)
							<tr>
								<td><strong>{{ $sector_category->name }}</strong></td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('sector_categories.edit', $sector_category->id), 'method' => 'get']) }}
										<button type="submit" class="primary" ><i class="fa fa-pencil"></i></button>
									{{ Form::close() }}
								</td>
								<td class="actions content-right hide-print">
									{{ Form::open(['route' => array('sector_categories.destroy', $sector_category->id), 'method' => 'delete']) }}
										<button type="submit" class="red-but delete-row" data-resource-type="sector category"><i class="fa fa-times"></i></button>
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