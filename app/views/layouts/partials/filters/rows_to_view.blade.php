<ul class="filter-options">
	<li class="title">View:</li>
	<li>
		@if(Session::get('index.rowsToView') == 10 || ! Session::get('index.rowsToView'))
			<strong>10</strong>
		@else
			<a href="?view=10">10</a>
		@endif
	</li>
	<li>
		@if(Session::get('index.rowsToView') == 25)
			<strong>25</strong>
		@else
			<a href="?view=25">25</a>
		@endif
	</li>
	<li>
		@if(Session::get('index.rowsToView') == 50)
			<strong>50</strong>
		@else
			<a href="?view=50">50</a>
		@endif
	</li>
	<li>
		@if( Session::get('index.rowsToView') == 99999)
			<strong>All</strong>
		@else
			<a href="?view=all">All</a>
		@endif
	</li>
</ul>