<?php namespace Leadofficelist\Knowledge_surveys;

use Illuminate\Support\Facades\Auth;

class UpdateLanguageInfoCommand {

	public $languages;
	public $fluent;

	function __construct( $languages, $fluent ) {
		$this->languages = $languages;
		$this->fluent = $fluent;
		$this->id = Auth::user()->id;
	}


}