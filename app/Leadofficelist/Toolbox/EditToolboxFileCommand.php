<?php namespace Leadofficelist\Toolbox;

class EditToolboxFileCommand {

	public $name;
	public $description;
	public $id;

	function __construct( $name, $description, $id ) {

		$this->name        = $name;
		$this->description = $description;
		$this->id          = $id;
	}

}