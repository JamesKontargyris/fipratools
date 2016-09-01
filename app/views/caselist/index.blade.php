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
		<li><a href="{{ route('cases.create') }}" class="secondary"><i class="fa fa-plus-circle"></i> Add a Case Study</a></li>
	@endif
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
							<td width="40%">Background</td>
							<td width="5%">Year</td>
							<td width="10%" class="hide-m">Sector</td>
							<td width="20%" class="hide-m">Product(s)</td>
							<td width="10%" class="hide-s">Unit</td>
							<td width="15%" class="hide-s">AD to talk to</td>
						</tr>
						<tr class="hide-print">
							<td class="hide-m sub-header"></td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
								{{ Form::select('filter_value', $years, null, ['class' => 'list-table-filter']) }}
								{{ Form::hidden('filter_field', 'year') }}
								{{ Form::hidden('filter_results', 'yes') }}
								{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
								{{ Form::select('filter_value', $sectors, null, ['class' => 'list-table-filter']) }}
								{{ Form::hidden('filter_field', 'sector_id') }}
								{{ Form::hidden('filter_results', 'yes') }}
								{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
									{{ Form::select('filter_value', $products, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'product_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
									{{ Form::select('filter_value', $units, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'unit_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
							<td class="hide-m sub-header">
								{{ Form::open(['url' => 'caselist/search']) }}
									{{ Form::select('filter_value', $account_directors, null, ['class' => 'list-table-filter']) }}
									{{ Form::hidden('filter_field', 'account_director_id') }}
									{{ Form::hidden('filter_results', 'yes') }}
									{{ Form::submit('Filter', ['class' => 'filter-submit-but hidejs']) }}
								{{ Form::close() }}
							</td>
						</tr>
					</thead>
					<tbody>
						@foreach($items as $case)
							<tr>
								<td><strong><a href="{{ route('cases.show', ['id' => $case->id]) }}">{{ $case->name }}</a></strong></td>
								<td>{{ $case->year }}</td>
								<td class="hide-m">{{ $case->sector()->pluck('name') }}</td>
								<td class="hide-m">{{ get_pretty_product_names(unserialize($case->product_id)); }}</td>
								<td class="hide-s"><a href="{{ route('units.show', ['id' => $case->unit()->pluck('id')]) }}"><strong>{{ $case->unit()->pluck('name') }}</strong></a></td>
								<td class="hide-s">{{ $case->account_director()->pluck('first_name') }} {{ $case->account_director()->pluck('last_name') }}</td>
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