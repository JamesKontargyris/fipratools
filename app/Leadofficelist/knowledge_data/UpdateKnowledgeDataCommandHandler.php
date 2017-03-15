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

		$this->knowledge_data->addData( Auth::user()->id, 'expertise_team', serialize($command->expertise_team), 1 );

		if(isset($command->company_function)) {
			$this->knowledge_data->addData( Auth::user()->id, 'company_function', serialize($command->company_function), 1 );
		}

		if(isset($command->public_office) && ! emptyArray($command->public_office)) {
			$this->knowledge_data->addData( Auth::user()->id, 'public_office', serialize($command->public_office), 1 );
		}

		if(isset($command->political_party) && ! emptyArray($command->political_party)) {
			$this->knowledge_data->addData( Auth::user()->id, 'political_party', serialize($command->political_party), 1 );
		}

		if($command->work_hours) $this->knowledge_data->addData( Auth::user()->id, 'work_hours', $command->work_hours );

		if($command->additional_info) $this->knowledge_data->addData( Auth::user()->id, 'additional_info', $command->additional_info );

		if($command->pa_pr_organisations) $this->knowledge_data->addData( Auth::user()->id, 'pa_pr_organisations', $command->pa_pr_organisations_details );

		if($command->registered_lobbyist) $this->knowledge_data->addData( Auth::user()->id, 'registered_lobbyist', $command->registered_lobbyist_details );

		if($command->formal_positions) $this->knowledge_data->addData( Auth::user()->id, 'formal_positions', $command->formal_positions_details );

		if($command->political_party_membership) $this->knowledge_data->addData( Auth::user()->id, 'political_party_membership', $command->political_party_membership_details );

		if($command->other_network) $this->knowledge_data->addData( Auth::user()->id, 'other_network', $command->other_network_details );

		return $this->knowledge_data;
	}
}