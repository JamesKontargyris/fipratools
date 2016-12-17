<ul class="site-nav-menu">
	@if($user->can('view_list') && section_is() == 'list')
		<li class="{{ nav_item_is_active('list') ? 'active' : '' }}"><a href="{{ route('list.index') }}"><i class="fa fa-th-list"></i> <strong>The List</strong></a></li>
	@endif
	@if($user->can('view_list') && section_is() == 'case')
		<li class="{{ nav_item_is_active('caselist') ? 'active' : '' }}"><a href="{{ route('caselist.index') }}"><i class="fa fa-th-list"></i> <strong>All Case Studies</strong></a></li>
	@endif
	@if($user->can('view_list') && section_is() == 'list')
		<li class="{{ nav_item_is_active('about') ? 'active' : '' }}"><a href="{{ route('list.about') }}"><i class="fa fa-info-circle"></i> <strong>About the List</strong></a></li>
	@endif
	@if($user->can('view_list') && section_is() == 'list')
		<li class="{{ nav_item_is_active('reports') ? 'active' : '' }}"><a href="{{ url('reports') }}"><i class="fa fa-pie-chart"></i> <strong>Reports</strong></a></li>
	@endif
	@if($user->can('manage_clients') && section_is() == 'list')
		<li class="{{ nav_item_is_active('clients') ? 'active' : '' }}">
			<a href="{{ route('clients.index') }}" class="{{ nav_item_is_active('clients') ? 'active' : '' }} has-extra-link">
				@if($user->hasRole('Administrator') || Request::is('clients/*'))
					Clients
				@else
					Your Clients
				@endif
			</a>
			<a href="{{ route('clients.create') }}" class="site-nav-extra-link" title="Add a new client"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_cases') && section_is() == 'case')
		<li class="{{ nav_item_is_active('cases') ? 'active' : '' }}">
			<a href="{{ route('cases.index') }}" class="{{ nav_item_is_active('cases') ? 'active' : '' }} has-extra-link">
				@if($user->hasRole('Administrator') || Request::is('cases/*'))
					Manage Case Studies
				@else
					Your Case Studies
				@endif
			</a>
			<a href="{{ route('cases.create') }}" class="site-nav-extra-link" title="Add a new case study"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_products')  && section_is() == 'case')
		<li class="{{ nav_item_is_active('products') ? 'active' : '' }}">
			<a href="{{ route('products.index') }}" class="has-extra-link">Products</a>
			<a href="{{ route('products.create') }}" class="site-nav-extra-link" title="Add a new product"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_units')  && (section_is() == 'list' || section_is() == 'case'))
		<li class="{{ nav_item_is_active('units') ? 'active' : '' }}">
			<a href="{{ route('units.index') }}" class="has-extra-link">Network</a>
			<a href="{{ route('units.create') }}" class="site-nav-extra-link" title="Add a new Unit"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_sectors') && (section_is() == 'list' || section_is() == 'case'))
		<li class="{{ nav_item_is_active('sectors') ? 'active' : '' }}">
			<a href="{{ route('sectors.index') }}" class="has-extra-link">Sectors</a>
			<a href="{{ route('sectors.create') }}" class="site-nav-extra-link" title="Add a new sector"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_types')  && section_is() == 'list')
		<li class="{{ nav_item_is_active('types') ? 'active' : '' }}">
			<a href="{{ route('types.index') }}" class="has-extra-link">Types</a>
			<a href="{{ route('types.create') }}" class="site-nav-extra-link" title="Add a new type"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_services')  && section_is() == 'list')
		<li class="{{ nav_item_is_active('services') ? 'active' : '' }}">
			<a href="{{ route('services.index') }}" class="has-extra-link">Services</a>
			<a href="{{ route('services.create') }}" class="site-nav-extra-link" title="Add a new service"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_knowledge') && section_is() == 'survey')
		<li class="{{ nav_item_is_active('knowledge_areas') ? 'active' : '' }}">
			<a href="{{ route('knowledge_areas.index') }}"><strong>Knowledge Areas</strong></a>
			<a href="{{ route('knowledge_areas.create') }}" class="site-nav-extra-link" title="Add a new knowledge area"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_knowledge') && section_is() == 'survey')
		<li class="{{ nav_item_is_active('knowledge_area_groups') ? 'active' : '' }}">
			<a href="{{ route('knowledge_area_groups.index') }}"><strong>Knowledge Area Groups</strong></a>
			<a href="{{ route('knowledge_area_groups.create') }}" class="site-nav-extra-link" title="Add a new knowledge area group"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->can('manage_knowledge') && section_is() == 'survey')
		<li class="{{ nav_item_is_active('knowledge_languages') ? 'active' : '' }}">
			<a href="{{ route('knowledge_languages.index') }}"><strong>Languages</strong></a>
			<a href="{{ route('knowledge_languages.create') }}" class="site-nav-extra-link" title="Add a new language"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif



	@if($user->hasRole('Administrator')  && (section_is() == 'list' || section_is() == 'case'))
		<li class="{{ nav_item_is_active('account_directors') ? 'active' : '' }}">
			<a href="{{ route('account_directors.index') }}" class="has-extra-link">ADs</a>
			<a href="{{ route('account_directors.create') }}" class="site-nav-extra-link" title="Add a new account director"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
	@if($user->hasRole('Administrator'))
		<li class="{{ nav_item_is_active('eventlog') ? 'active' : '' }} hang-right"><a href="{{ url('eventlog') }}"><i class="fa fa-table"></i> <strong>Event Log</strong></a></li>
	@endif
	@if($user->can('manage_users'))
		<li class="{{ nav_item_is_active('users') ? 'active' : '' }} hang-right">
			<a href="{{ route('users.index') }}" class="has-extra-link">Users</a>
			<a href="{{ route('users.create') }}" class="site-nav-extra-link" title="Add a new user"><i class="fa fa-plus-circle"></i></a>
		</li>
	@endif
</ul>