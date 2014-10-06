<div class="row">
	<div class="col-12">
		<p>No records found.</p>
		@if(is_search())
			<a class="primary" href="{{ route($items->key . '.index') }}"><i class="fa fa-caret-left"></i> Back to overview</a>
		@endif
	</div>
</div>