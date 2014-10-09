<?php namespace Leadofficelist\Sector_categories;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditSectorCategoryCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $sector_category;

	function __construct(Sector_category $sector_category) {

		$this->sector_category = $sector_category;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->sector_category->edit($command);

		return $this->sector_category;
	}
}