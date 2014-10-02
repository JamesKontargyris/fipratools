<ul class="filter-options">
	<li class="title">Sort:</li>
	<li>
		@if(Session::get('index.rowsSort') == 'name.asc' || ! Session::get('index.rowsSort'))
			<strong>A-Z</strong>
		@else
			<a href="?sort=az">A-Z</a>
		@endif
	</li>
	<li>
		@if(Session::get('index.rowsSort') == 'name.desc')
			<strong>Z-A</strong>
		@else
			<a href="?sort=za">Z-A</a>
		@endif
	</li>
	<li>
		@if(Session::get('index.rowsSort') == 'id.desc')
			<strong>Newest</strong>
		@else
			<a href="?sort=newest">Newest</a>
		@endif
	</li>
	<li>
		@if( Session::get('index.rowsSort') == 'id.asc')
			<strong>Oldest</strong>
		@else
			<a href="?sort=oldest">Oldest</a>
		@endif
	</li>
</ul>