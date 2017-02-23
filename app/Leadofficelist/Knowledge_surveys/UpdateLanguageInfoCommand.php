<?php namespace Leadofficelist\Knowledge_surveys;

use Illuminate\Support\Facades\Auth;

class UpdateLanguageInfoCommand {

	public $languages;

	function __construct( $languages ) {
		$this->languages = $languages;
		$this->id = Auth::user()->id;
	}


}