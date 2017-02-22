<?php namespace Leadofficelist\Knowledge_languages;

class AddKnowledgeLanguageCommand {
	public $name;

	function __construct( $name ) {
		$this->name = trim($name);
	}


}