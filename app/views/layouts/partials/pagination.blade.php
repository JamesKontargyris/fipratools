@if($items->links() != '')
	<li class="hide-print">
		<ul class="pagination">
			<?php echo with(new Leadofficelist\Presenters\PaginationPresenter($items))->render(); ?>
		</ul>
	</li>
@endif