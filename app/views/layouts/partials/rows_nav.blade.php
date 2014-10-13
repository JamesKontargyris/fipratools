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
				{{ Form::open(['url' => $items->key . '/search']) }}
					{{ Form::text('search', null, ['placeholder' => "Search " . str_replace('_', ' ', $items->key) . "..."]) }}
					<button type="submit" class="search-but"><i class="fa fa-search"></i></button>
				{{ Form::close() }}
			</li>
			@if(is_search())
				<li><a href="{{ route($items->key . '.index', ['clear_search' => 'true']) }}" class="primary clear-search-but"><i class="fa fa-times"></i> Clear Search</a></li>
			@endif
		</ul>
	</div>
</section>