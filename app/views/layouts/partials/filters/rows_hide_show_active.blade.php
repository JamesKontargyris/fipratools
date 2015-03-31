@if(Session::get($items->key . '.rowsHideShowActive') == 'hide')
	<a href="?active=show" class="filter-but highlight"><i class="fa fa-eye"></i> Show Active</a>
@elseif(Session::get($items->key . '.rowsHideShowDormant') == 'show')
	<a href="?active=hide" class="filter-but highlight"><i class="fa fa-eye-slash"></i> Hide Active</a>
@endif