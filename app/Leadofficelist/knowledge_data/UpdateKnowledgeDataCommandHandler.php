<?php namespace Leadofficelist\Knowledge_data;

use Auth;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class UpdateKnowledgeDataCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $knowledge_data;

	function __construct( KnowledgeData $knowledge_data ) {

		$this->knowledge_data = $knowledge_data;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle( $command ) {

		// Get rid of any existing rows, ready to add new ones for the new content
		KnowledgeData::where('user_id', '=', $command->id)->delete();

		if($command->other_languages) $this->knowledge_data->addData( Auth::user()->id, 'other_languages', $command->other_languages );

		if($command->other_network) $this->knowledge_data->addData( Auth::user()->id, 'other_network', $command->other_network );

		if($command->formal_positions) $this->knowledge_data->addData( Auth::user()->id, 'formal_positions', $command->formal_positions );

		$this->knowledge_data->addData( Auth::user()->id, 'expertise_team', serialize($command->expertise_team), 1 );

		if(isset($command->company_function)) {
			$this->knowledge_data->addData( Auth::user()->id, 'company_function', serialize($command->company_function), 1 );
		}

		if(isset($command->public_office) && ! emptyArray($command->public_office)) {
			$this->knowledge_data->addData( Auth::user()->id, 'public_office', serialize($command->public_office), 1 );
		}


		return $this->knowledge_data;
	}
}