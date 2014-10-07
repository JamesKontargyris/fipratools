<ul class="site-nav-menu">
	<li class="{{ nav_item_is_active('/') ? 'active' : '' }}"><a href="#"><i class="fa fa-list"></i> <strong>Lead Office List</strong></a></li>
	<li class="{{ nav_item_is_active('reports') ? 'active' : '' }}"><a href="{{ route('reports.index') }}"><i class="fa fa-file"></i> <strong>Reports</strong></a></li>
	<li>
		<a href="#" class="{{ nav_item_is_active('clients') ? 'active' : '' }} has-extra-link">Clients</a>
		<a href="#" class="site-nav-extra-link" title="Add a new client"><i class="fa fa-plus-circle"></i></a>
	</li>
	<li>
		<a href="#" class="{{ nav_item_is_active('users') ? 'active' : '' }} has-extra-link">Users</a>
		<a href="{{ route('users.create') }}" class="site-nav-extra-link" title="Add a new user"><i class="fa fa-plus-circle"></i></a>
	</li>
	<li class="{{ nav_item_is_active('units') ? 'active' : '' }}">
		<a href="{{ route('units.index') }}" class="has-extra-link">Units</a>
		<a href="{{ route('units.create') }}" class="site-nav-extra-link" title="Add a new Unit"><i class="fa fa-plus-circle"></i></a>
	</li>
	<li class="{{ nav_item_is_active('sectors') ? 'active' : '' }}">
		<a href="{{ route('sectors.index') }}" class="has-extra-link">Sectors</a>
		<a href="{{ route('sectors.create') }}" class="site-nav-extra-link" title="Add a new sector"><i class="fa fa-plus-circle"></i></a>
	</li>
	<li class="{{ nav_item_is_active('types') ? 'active' : '' }}">
		<a href="{{ route('types.index') }}" class="has-extra-link">Types</a>
		<a href="{{ route('types.create') }}" class="site-nav-extra-link" title="Add a new type"><i class="fa fa-plus-circle"></i></a>
	</li>
	<li class="{{ nav_item_is_active('services') ? 'active' : '' }}">
		<a href="#" class="has-extra-link">Services</a>
		<a href="#" class="site-nav-extra-link" title="Add a new service"><i class="fa fa-plus-circle"></i></a>
	</li>
</ul>