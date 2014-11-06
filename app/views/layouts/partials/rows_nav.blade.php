<section class="rows-nav-container row no-margin">
	<div class="col-12">
		<ul class="rows-nav">

			@include('layouts.partials.pagination')

			<li>Viewing <strong>{{ number_format($items->getFrom(),0, 0, ',') }}-{{ number_format($items->getTo(),0, 0, ',') }}</strong> of <strong>{{ number_format($items->getTotal(),0, 0, ',') }}</strong></li>
			<li class="hide-m hide-print">Page {{ str_replace('Page ', '', number_format($items->getCurrentPage(),0, 0, ',')) }} of {{ str_replace('Page ', '', number_format($items->getLastPage(),0, 0, ',')) }}</li>
			<li class="search-container hide-print">
				{{ Form::open(['url' => $items->key . '/search']) }}
					{{ Form::text('search', null, ['placeholder' => "Search " . str_replace('_', ' ', $items->key) . "..."]) }}
					<button type="submit" class="search-but"><i class="fa fa-search"></i></button>
				{{ Form::close() }}
			</li>
			@if(is_filter())
				<li class="hide-print"><a href="{{ route($items->key . '.index', ['clear_search' => 'true']) }}" class="primary clear-search-but"><i class="fa fa-times"></i> Clear Filter</a></li>
			@elseif(is_search())
				<li class="hide-print"><a href="{{ route($items->key . '.index', ['clear_search' => 'true']) }}" class="primary clear-search-but"><i class="fa fa-times"></i> Clear Search</a></li>
			@endif
		</ul>
	</div>
</section>