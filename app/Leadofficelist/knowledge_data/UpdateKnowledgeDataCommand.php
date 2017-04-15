<?php namespace Leadofficelist\Knowledge_data;

use Illuminate\Support\Facades\Auth;

class UpdateKnowledgeDataCommand {

	public $expertise_team;
	public $other_languages;
	public $expertise_team_details;
	public $company_function;
	public $company_function_details;
	public $public_office;
	public $political_party;
	public $work_hours;
	public $additional_info;
	public $pa_pr_organisations;
	public $pa_pr_organisations_details;
	public $registered_lobbyist;
	public $registered_lobbyist_details;
	public $formal_positions;
	public $formal_positions_details;
	public $political_party_membership;
	public $political_party_membership_details;
	public $other_network;
	public $other_network_details;
	public $no_memberships;
	public $survey_name;

	function __construct( $expertise_team = [], $other_languages, $expertise_team_details, $company_function_details, $company_function = [], $public_office, $political_party, $work_hours, $additional_info, $pa_pr_organisations = 0, $pa_pr_organisations_details, $registered_lobbyist = 0, $registered_lobbyist_details, $formal_positions = 0, $formal_positions_details, $political_party_membership = 0, $political_party_membership_details, $other_network = 0, $other_network_details, $no_memberships = 0, $survey_name = '' ) {
		$this->expertise_team                     = $expertise_team;
		$this->other_languages                    = $other_languages;
		$this->expertise_team_details             = $expertise_team_details;
		$this->company_function                   = $company_function;
		$this->company_function_details           = $company_function_details;
		$this->work_hours                         = $work_hours;
		$this->additional_info                    = trim( $additional_info );
		$this->pa_pr_organisations                = $pa_pr_organisations;
		$this->pa_pr_organisations_details        = trim( $pa_pr_organisations_details );
		$this->registered_lobbyist                = $registered_lobbyist;
		$this->registered_lobbyist_details        = trim( $registered_lobbyist_details );
		$this->formal_positions                   = $formal_positions;
		$this->formal_positions_details           = trim( $formal_positions_details );
		$this->political_party_membership         = $political_party_membership;
		$this->political_party_membership_details = trim( $political_party_membership_details );
		$this->other_network                      = $other_network;
		$this->other_network_details              = trim( $other_network_details );
		$this->no_memberships                     = $no_memberships;
		$this->survey_name                        = $survey_name;
		$this->id                                 = Auth::user()->id;

		$public_office_clean = [];
		foreach ( $public_office as $position ) {
			if ( ! emptyArray( $position ) ) {
				$public_office_clean[] = $position;
			}
		}
		$this->public_office = $public_office_clean;

		$political_party_clean = [];
		foreach ( $political_party as $position ) {
			if ( ! emptyArray( $position ) ) {
				$political_party_clean[] = $position;
			}
		}
		$this->political_party = $political_party_clean;
	}


}