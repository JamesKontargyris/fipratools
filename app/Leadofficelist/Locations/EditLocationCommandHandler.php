<?php namespace Leadofficelist\Locations;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Locations\Location;

class EditLocationCommandHandler implements CommandHandler {

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

		$this->location->edit($command);

		return $this->location;
	}
}