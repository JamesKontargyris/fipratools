<?php namespace Leadofficelist\Knowledge_area_groups;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Location;
use Leadofficelist\Products\Product;

class AddKnowledgeAreaGroupCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $knowledge_area_group;

	function __construct(\KnowledgeAreaGroup $knowledge_area_group) {

		$this->knowledge_area_group = $knowledge_area_group;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->knowledge_area_group->add($command);

		return $this->knowledge_area_group;
	}
}