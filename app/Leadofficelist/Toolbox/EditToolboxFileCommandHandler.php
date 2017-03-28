<?php namespace Leadofficelist\Toolbox;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditToolboxFileCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $toolbox;

	function __construct(Toolbox $toolbox) {


		$this->toolbox = $toolbox;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->toolbox->editFile($command);

		return $this->toolbox;
	}
}