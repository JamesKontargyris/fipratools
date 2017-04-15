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
		KnowledgeData::where('user_id', '=', $command->id)->where('survey_name', '=', $command->survey_name)->delete();

		if($command->other_languages) {
			$this->knowledge_data->addData( Auth::user()->id, 'other_languages', $command->other_languages, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'other_languages', $command->survey_name );
		}

		if($command->expertise_team) {
			$this->knowledge_data->addData( Auth::user()->id, 'expertise_team', serialize($command->expertise_team), $command->survey_name, 1 );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'expertise_team', $command->survey_name );
		}

		if($command->expertise_team_details) {
			$this->knowledge_data->addData( Auth::user()->id, 'expertise_team_details', serialize($command->expertise_team_details), $command->survey_name, 1 );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'expertise_team_details', $command->survey_name );
		}

		if($command->company_function) {
			$this->knowledge_data->addData( Auth::user()->id, 'company_function', serialize($command->company_function), $command->survey_name, 1 );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'company_function', $command->survey_name );
		}

		if($command->company_function_details) {
			$this->knowledge_data->addData( Auth::user()->id, 'company_function_details', serialize($command->company_function_details), $command->survey_name, 1 );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'company_function_details', $command->survey_name );
		}

		if(isset($command->public_office) && ! emptyArray($command->public_office)) {
			$this->knowledge_data->addData( Auth::user()->id, 'public_office', serialize($command->public_office), $command->survey_name, 1 );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'public_office' );
		}

		if(isset($command->political_party) && ! emptyArray($command->political_party)) {
			$this->knowledge_data->addData( Auth::user()->id, 'political_party', serialize($command->political_party), $command->survey_name, 1 );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'political_party', $command->survey_name );
		}

		if($command->work_hours) {
			$this->knowledge_data->addData( Auth::user()->id, 'work_hours', $command->work_hours, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'work_hours', $command->survey_name, $command->survey_name );
		}

		if($command->additional_info) {
			$this->knowledge_data->addData( Auth::user()->id, 'additional_info', $command->additional_info, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'additional_info', $command->additional_info, $command->survey_name );
		}

		if($command->pa_pr_organisations && ! $command->no_memberships) {
			$this->knowledge_data->addData( Auth::user()->id, 'pa_pr_organisations', $command->pa_pr_organisations_details, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'pa_pr_organisations', $command->survey_name );
		}

		if($command->registered_lobbyist && ! $command->no_memberships) {
			$this->knowledge_data->addData( Auth::user()->id, 'registered_lobbyist', $command->registered_lobbyist_details, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'registered_lobbyist', $command->survey_name );
		}

		if($command->formal_positions && ! $command->no_memberships) {
			$this->knowledge_data->addData( Auth::user()->id, 'formal_positions', $command->formal_positions_details, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'formal_positions', $command->survey_name );
		}

		if($command->political_party_membership && ! $command->no_memberships) {
			$this->knowledge_data->addData( Auth::user()->id, 'political_party_membership', $command->political_party_membership_details, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'political_party_membership', $command->survey_name );
		}

		if($command->other_network && ! $command->no_memberships) {
			$this->knowledge_data->addData( Auth::user()->id, 'other_network', $command->other_network_details, $command->survey_name );
		} else {
			$this->knowledge_data->deleteData( Auth::user()->id, 'other_network', $command->survey_name );
		}

		return $this->knowledge_data;
	}
}