<section class="pagination-container">
	@if($items->links() != '')
		<div class="row">
			<div class="col-12">
				{{ $items->links() }}
			</div>
		</div>
	@endif
</section>