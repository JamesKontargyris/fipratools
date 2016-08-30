<?php namespace Leadofficelist\Locations;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Sector_categories\Sector_category;
use Location;

class AddLocationCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $location;

	function __construct(Location $location) {

		$this->location = $location;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->location->add($command);

		return $this->location;
	}
}