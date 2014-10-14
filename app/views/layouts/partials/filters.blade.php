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
			@if(is_request('clients'))
			<ul>
			    <li class="letter-select-table-container">
			    	<table class="letter-select-table">
			    		<tr>
			    		    <td><a href="{{ url('clients/search?search=A&letter=yes') }}" class="secondary">A</a></td>
			    		    <td><a href="{{ url('clients/search?search=B&letter=yes')}}" class="secondary">B</a></td>
			    		    <td><a href="{{ url('clients/search?search=C&letter=yes')}}" class="secondary">C</a></td>
			    		    <td><a href="{{ url('clients/search?search=D&letter=yes')}}" class="secondary">D</a></td>
			    		    <td><a href="{{ url('clients/search?search=E&letter=yes')}}" class="secondary">E</a></td>
			    		    <td><a href="{{ url('clients/search?search=F&letter=yes')}}" class="secondary">F</a></td>
			    		    <td><a href="{{ url('clients/search?search=G&letter=yes')}}" class="secondary">G</a></td>
			    		    <td><a href="{{ url('clients/search?search=H&letter=yes')}}" class="secondary">H</a></td>
			    		    <td><a href="{{ url('clients/search?search=I&letter=yes')}}" class="secondary">I</a></td>
			    		    <td><a href="{{ url('clients/search?search=J&letter=yes')}}" class="secondary">J</a></td>
			    		    <td><a href="{{ url('clients/search?search=K&letter=yes')}}" class="secondary">K</a></td>
			    		    <td><a href="{{ url('clients/search?search=L&letter=yes')}}" class="secondary">L</a></td>
			    		    <td><a href="{{ url('clients/search?search=M&letter=yes')}}" class="secondary">M</a></td>
			    		    <td><a href="{{ url('clients/search?search=N&letter=yes')}}" class="secondary">N</a></td>
			    		    <td><a href="{{ url('clients/search?search=O&letter=yes')}}" class="secondary">O</a></td>
			    		    <td><a href="{{ url('clients/search?search=P&letter=yes')}}" class="secondary">P</a></td>
			    		    <td><a href="{{ url('clients/search?search=Q&letter=yes')}}" class="secondary">Q</a></td>
			    		    <td><a href="{{ url('clients/search?search=R&letter=yes')}}" class="secondary">R</a></td>
			    		    <td><a href="{{ url('clients/search?search=S&letter=yes')}}" class="secondary">S</a></td>
			    		    <td><a href="{{ url('clients/search?search=T&letter=yes')}}" class="secondary">T</a></td>
			    		    <td><a href="{{ url('clients/search?search=U&letter=yes')}}" class="secondary">U</a></td>
			    		    <td><a href="{{ url('clients/search?search=V&letter=yes')}}" class="secondary">V</a></td>
			    		    <td><a href="{{ url('clients/search?search=W&letter=yes')}}" class="secondary">W</a></td>
			    		    <td><a href="{{ url('clients/search?search=X&letter=yes')}}" class="secondary">X</a></td>
			    		    <td><a href="{{ url('clients/search?search=Y&letter=yes')}}" class="secondary">Y</a></td>
			    		    <td><a href="{{ url('clients/search?search=Z&letter=yes')}}" class="secondary">Z</a></td>
			    		    </tr>
			    	</table>
			    </li>
			    </ul>
			@endif
		</div>
	</div>
</section>