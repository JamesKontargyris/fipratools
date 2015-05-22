<?php namespace Leadofficelist\Unit_groups;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditUnitGroupCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $unit_group;

	function __construct(Unit_group $unit_group) {

		$this->unit_group = $unit_group;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->unit_group->edit($command);

		return $this->unit_group;
	}
}