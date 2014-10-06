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