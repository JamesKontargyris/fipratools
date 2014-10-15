<ul class="filter-options">
	<li class="title">Per Page:</li>
	<li>
		@if(Session::get($items->key . '.rowsToView') == 10 || ! Session::get($items->key . '.rowsToView'))
			<strong>10</strong>
		@else
			<a href="/{{ $items->key }}?view=10">10</a>
		@endif
	</li>
	<li>
		@if(Session::get($items->key . '.rowsToView') == 25)
			<strong>25</strong>
		@else
			<a href="/{{ $items->key }}?view=25">25</a>
		@endif
	</li>
	<li>
		@if(Session::get($items->key . '.rowsToView') == 50)
			<strong>50</strong>
		@else
			<a href="/{{ $items->key }}?view=50">50</a>
		@endif
	</li>
	<li>
		@if( Session::get($items->key . '.rowsToView') == 99999)
			<strong>All</strong>
		@else
			<a href="/{{ $items->key }}?view=all">All</a>
		@endif
	</li>
</ul>