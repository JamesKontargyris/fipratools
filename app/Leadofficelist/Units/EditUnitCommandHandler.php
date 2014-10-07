<?php namespace Leadofficelist\Units;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditUnitCommandHandler implements CommandHandler {

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
	}
}