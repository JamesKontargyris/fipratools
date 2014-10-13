<section class="row no-margin">
	<div class="col-12 filter-container">
		<a class="filter-menu-icon-m" href="#">Filters</a>
		<div class="col-12 filters">
			<ul>
				@if(is_request('clients'))
					<li>@include('layouts.partials.filters.rows_hide_show_dormant')</li>
				@endif
				<li>@include('layouts.partials.filters.rows_to_view')</li>
				<li>@include('layouts.partials.filters.rows_sort_order')</li>
				@if(is_request('users'))
					<li>@include('layouts.partials.filters.rows_name_order')</li>
				@endif
				<li><a href="?reset_filters=yes" class="filter-but"><i class="fa fa-undo"></i> Reset Filters</a></li>
			</ul>
		</div>
	</div>
</section>