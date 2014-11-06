<section class="pagination-container hide-print">
	@if($items->links() != '')
		<div class="row">
			<div class="col-12">
				<ul class="pagination">
					<?php echo with(new Leadofficelist\Presenters\PaginationPresenter($items))->render(); ?>
				</ul>
			</div>
		</div>
	@endif
</section>