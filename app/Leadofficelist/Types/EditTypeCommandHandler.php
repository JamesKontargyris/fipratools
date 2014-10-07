<?php namespace Leadofficelist\Types;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditTypeCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $type;

	function __construct(Type $type) {

		$this->type = $type;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->type->edit($command);

		return $this->type;
	}
}