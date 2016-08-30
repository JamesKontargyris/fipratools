<?php namespace Leadofficelist\Cases;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class AddCaseCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $case;

	function __construct(CaseStudy $case) {

		$this->case = $case;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->case->add($command);

		return $this->case;
	}
}