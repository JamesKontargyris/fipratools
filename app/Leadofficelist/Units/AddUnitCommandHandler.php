<?php namespace Leadofficelist\Clients;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditClientCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $unit;

	function __construct(Unit $unit) {

		$this->unit = $unit;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->unit->edit($command);

		return $this->unit;
		//$this->dispatchEventsFor($this->unit);
	}
}