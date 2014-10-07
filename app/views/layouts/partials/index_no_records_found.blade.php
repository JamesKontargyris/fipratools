<div class="row">
	<div class="col-12 alert alert-info">
		No records found.
		@if(is_search())
			<a class="primary" href="{{ route($items->key . '.index') }}"><i class="fa fa-caret-left"></i> Back to overview</a>
		@endif
	</div>
</div>