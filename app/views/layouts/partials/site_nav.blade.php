<ul class="site-nav-menu">
	@if($user->can('view_list'))
		<li class="{{ nav_item_is_active('list') ? 'active' : '' }}"><a href="{{ route('list.index') }}"><i class="fa fa-list"></i> <strong>Lead Office List</strong></a></li>
	@endif
	@if($user->can('view_list') && ! $user->hasRole('Administrator'))
		<li class="{{ nav_item_is_active('about') ? 'active' : '' }}"><a href="{{ route('list.about') }}"><i class="fa fa-info-circle"></i> <strong>About the List</strong></a></li>
	@endif
	@if($user->can('view_list'))
		{{--<li class="{{ nav_item_is_active('reports') ? 'active' : '' }}"><a href="{{ route('reports.index') }}"><i class="fa fa-pie-chart"></i> <strong>Reports</strong></a></li>--}}
	@endif
	@if($user->can('manage_clients'))
		<li class="{{ nav_item_is_active('clients') ? 'active' : '' }}">
			<a href="{{ route('clients.index') }}" class="{{ nav_item_is_active('clients') ? 'active' : '' }} has-extra-link">
				@if($user->hasRole('Administrator'))
					Clients
				@else
					Your Clients
				@endif
			</a>
			<a href="{{ route('clients.create') }}" class="site-nav-extra-link" title="Add a new client"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_users'))
		<li class="{{ nav_item_is_active('users') ? 'active' : '' }}">
			<a href="{{ route('users.index') }}" class="has-extra-link">Users</a>
			<a href="{{ route('users.create') }}" class="site-nav-extra-link" title="Add a new user"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_units'))
		<li class="{{ nav_item_is_active('units') ? 'active' : '' }}">
			<a href="{{ route('units.index') }}" class="has-extra-link">Units</a>
			<a href="{{ route('units.create') }}" class="site-nav-extra-link" title="Add a new Unit"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_sectors'))
		<li class="{{ nav_item_is_active('sectors') ? 'active' : '' }}">
			<a href="{{ route('sectors.index') }}" class="has-extra-link">Sectors</a>
			<a href="{{ route('sectors.create') }}" class="site-nav-extra-link" title="Add a new sector"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_types'))
		<li class="{{ nav_item_is_active('types') ? 'active' : '' }}">
			<a href="{{ route('types.index') }}" class="has-extra-link">Types</a>
			<a href="{{ route('types.create') }}" class="site-nav-extra-link" title="Add a new type"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_services'))
		<li class="{{ nav_item_is_active('services') ? 'active' : '' }}">
			<a href="{{ route('services.index') }}" class="has-extra-link">Services</a>
			<a href="{{ route('services.create') }}" class="site-nav-extra-link" title="Add a new service"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
</ul>