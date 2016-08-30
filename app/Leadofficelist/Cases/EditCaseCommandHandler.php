<?php namespace Leadofficelist\Cases;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Cases\CaseStudy;

class EditCaseCommandHandler implements CommandHandler {

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

		$this->case->edit($command);

		return $this->case;
	}
}