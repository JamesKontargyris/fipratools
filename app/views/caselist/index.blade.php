@extends('layouts.list')

@section('page-header')
@if(is_filter($items->key))
	<i class="fa fa-filter"></i> Filtering on: {{ $items->filter_value }}

@elseif(is_search())
	<i class="fa fa-search"></i> Searching for {{ Session::has('caselist.SearchType') ? Session::get('caselist.SearchType') : '' }}: {{ $items->search_term }}
@else
    Case Studies
@endif
@stop

@section('page-nav')
	@if($user->can('manage_cases'))
		<li><a href="{{ route('cases.create') }}" class="primary"><i class="fa fa-plus-circle"></i> Add a Case Study</a></li>
	@endif
@stop

@section('content')

@include('layouts.partials.messages')

@if(count($items) > 0)

	@if(get_widget('case_studies_details'))
		<div class="row">
			<div class="col-12">
				{{ nl2br(get_widget('case_studies_details')) }}
			</div>
		</div>
	@endif

	@include('layouts.partials.rows_nav')

	@include('layouts.partials.filters')

	<section class="index-table-container">
		<div class="row">
			<div class="col-12">
				<table width="100%" class="index-table">
					<thead>
						<tr>
							<td width="8%">Year</td>
							<td width="10%">Client where disclosable</td>
							<td width="25%">Background</td>
							<td width="10%" class="hide-s">Unit</td>
							<td colspan="2" width="20%" class="hide-m">Sector(s) and Expertise Area(s)</td>
							<td width="22%" class="hide-m">Product(s)</td>
							<td width="5%" class="hide-print"></td>
						</tr>
						<tr class="hide-print">
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
								{{ Form::select('filter_value', $years, Session::has('caselist.Filters.year') ? Session::get('caselist.Filters.year') : null, ['class' => 'list-table-filter select2', 'style' => 'width:100%']) }}
								{{ Form::hidden('filter_field', 'year') }}
								{{ Form::hidden('filter_results', 'yes') }}
								{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header"></td>
							<td class="hide-m sub-header"></td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
									{{ Form::select('filter_value', $units, Session::has('caselist.Filters.unit_id') ? Session::get('caselist.Filters.unit_id') : null, ['class' => 'list-table-filter select2', 'style' => 'width:100%']) }}
									{{ Form::hidden('filter_field', 'unit_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td width="15%" class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
								{{ Form::select('filter_value', $sectors, Session::has('caselist.Filters.sector_id') ? Session::get('caselist.Filters.sector_id') : null, ['class' => 'list-table-filter select2', 'style' => 'width:100%']) }}
								{{ Form::hidden('filter_field', 'sector_id') }}
								{{ Form::hidden('filter_results', 'yes') }}
								{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td width="15%" class="hide-m sub-header no-border-left">
								{{ Form::open(['url' => 'caselist/search']) }}
								{{ Form::select('filter_value', $sector_categories, Session::has('caselist.Filters.sector_category_id') ? Session::get('caselist.Filters.sector_category_id') : null, ['class' => 'list-table-filter select2', 'style' => 'width:100%']) }}
								{{ Form::hidden('filter_field', 'sector_category_id') }}
								{{ Form::hidden('filter_results', 'yes') }}
								{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
								{{ Form::select('filter_value', $products, Session::has('caselist.Filters.product_id') ? Session::get('caselist.Filters.product_id') : null, ['class' => 'list-table-filter select2', 'style' => 'width:100%']) }}
								{{ Form::hidden('filter_field', 'product_id') }}
								{{ Form::hidden('filter_results', 'yes') }}
								{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header hide-print"></td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $case)
							<tr>
								<td>{{ $case->year }}</td>
								<td>{{ ! $case->client_id ? (! $case->client ? 'Anonymous' : $case->client) : '<a
                                            href="' . route('clients.show', $case->client()->first()->id) . '"><strong>' . $case->client()->first()->name . '</strong></a>' }}</td>
								<td>{{ $case->name }}</td>
								<td class="hide-s"><a href="{{ route('units.show', ['id' => $case->unit()->pluck('id')]) }}"><strong>{{ $case->unit()->pluck('name') }}</strong></a></td>
								<td class="hide-m">{{ get_pretty_sector_names(unserialize($case->sector_id)) }}</td>
								<td class="hide-m expertise-field">
									<?php
									// Get the expertise areas (called Sector Areas here) that are associated with each sector
									$sectors = unserialize($case->sector_id);
									$expertiseAreas = [];
									foreach($sectors as $sector) {
										if($sectorObj = \Leadofficelist\Sectors\Sector::find($sector)) {
											$expertiseAreas[] = \Leadofficelist\Sector_categories\Sector_category::find($sectorObj->category_id)['name'];
										}
									}
									?>

									@if($expertiseAreas)
										<div class="expertise-field__text-container">
											{{ implode(array_unique($expertiseAreas), ' &bull; ') }}
											<i class="fa fa-caret-left fa-lg expertise-field__pointer"></i>
										</div>
									@endif
								</td>
								<td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
								<td class="hide-print"><strong><a href="{{ route('cases.show', ['id' => $case->id]) }}">View</a></strong></td>
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