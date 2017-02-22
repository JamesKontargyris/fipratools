<?php namespace Leadofficelist\Knowledge_languages;

class EditKnowledgeLanguageCommand
{
	public $name;

	function __construct( $name, $id )
	{
		$this->name = trim($name);
		$this->id   = $id;
	}

}