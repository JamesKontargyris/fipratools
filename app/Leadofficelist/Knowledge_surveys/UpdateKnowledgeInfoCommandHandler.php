<?php namespace Leadofficelist\Knowledge_surveys;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Knowledge_areas\KnowledgeArea;

class UpdateKnowledgeInfoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $knowledge_areas;

	function __construct( KnowledgeArea $knowledge_areas ) {

		$this->knowledge_areas = $knowledge_areas;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle( $command ) {

		$this->knowledge_areas->updateKnowledgeAreaInfo( $command );

		return $this->knowledge_areas;
	}
}