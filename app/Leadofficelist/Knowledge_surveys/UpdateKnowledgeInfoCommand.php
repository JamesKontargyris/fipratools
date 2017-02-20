<?php namespace Leadofficelist\Knowledge_surveys;

use Illuminate\Support\Facades\Auth;

class UpdateKnowledgeInfoCommand {

	public $areas;

	function __construct( $areas ) {
		$this->areas = $areas;
		$this->id = Auth::user()->id;
	}


}