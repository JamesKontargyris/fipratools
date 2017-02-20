<?php namespace Leadofficelist\Knowledge_areas;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Location;

class EditKnowledgeAreaCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $knowledge_area;

	function __construct( KnowledgeArea $knowledge_area) {

		$this->knowledge_area = $knowledge_area;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->knowledge_area->edit($command);

		return $this->knowledge_area;
	}
}