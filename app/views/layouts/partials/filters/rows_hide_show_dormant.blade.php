@if(Session::get($items->key . '.rowsHideShowDormant') == 'hide' || ! Session::get($items->key . '.rowsHideShowDormant'))
	<a href="?dormant=show" class="filter-but highlight"><i class="fa fa-eye"></i> Show Dormant</a>
@else
	<a href="?dormant=hide" class="filter-but highlight"><i class="fa fa-eye-slash"></i> Hide Dormant</a>
@endif