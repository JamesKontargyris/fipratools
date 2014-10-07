<?php namespace Leadofficelist\Services;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class AddServiceCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $service;

	function __construct(Service $service) {

		$this->service = $service;

	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->service->add($command);

		return $this->service;
	}
}