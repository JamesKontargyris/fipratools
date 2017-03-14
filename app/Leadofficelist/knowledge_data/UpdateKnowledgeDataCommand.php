<?php namespace Leadofficelist\Knowledge_data;

use Illuminate\Support\Facades\Auth;

class UpdateKnowledgeDataCommand {

	public $other_network;
	public $formal_positions;
	public $expertise_team;
	public $other_languages;
	public $company_function;

	function __construct( $other_network, $formal_positions, $expertise_team, $other_languages, $company_function ) {
		$this->other_network    = trim( $other_network );
		$this->formal_positions = trim( $formal_positions );
		$this->expertise_team   = $expertise_team;
		$this->other_languages = $other_languages;
		$this->company_function = $company_function;
		$this->id               = Auth::user()->id;
	}


}