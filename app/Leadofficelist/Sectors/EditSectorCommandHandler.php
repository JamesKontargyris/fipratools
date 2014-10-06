<?php namespace Leadofficelist\Sectors;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditSectorCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $sector;

	function __construct(Sector $sector) {

		$this->sector = $sector;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->sector->edit($command);

		return $this->sector;
	}
}