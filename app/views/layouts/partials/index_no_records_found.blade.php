<div class="no-margin">
	<div class="alert alert-info-alt">
		No records found.
	</div>
	@if(is_search())
		<a class="primary" href="{{ route($items->key . '.index', ['clear_search', 'yes']) }}"><i class="fa fa-caret-left"></i> Back to overview</a>
	@endif
</div>