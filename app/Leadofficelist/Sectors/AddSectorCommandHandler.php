<?php namespace Leadofficelist\Sectors;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Sector_categories\Sector_category;

class AddSectorCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $sector;
	private $sector_category;

	function __construct(Sector $sector, Sector_category $sector_category) {

		$this->sector = $sector;
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

		$command->category_id = $this->sector_category->addWithSector($command);
		$this->sector->add($command);

		return $this->sector;
	}
}