<ul class="filter-options">
	<li class="title">Name Order:</li>
	<li>
		@if(Session::get($items->key . '.rowsNameOrder') == 'first_last' || ! Session::get($items->key . '.rowsNameOrder'))
			<strong>First, Last</strong>
		@else
			<a href="?name=first_last">First, Last</a>
		@endif
	</li>
	<li>
		@if(Session::get($items->key . '.rowsNameOrder') == 'last_first')
			<strong>Last, First</strong>
		@else
			<a href="?name=last_first">Last, First</a>
		@endif
	</li>
</ul>