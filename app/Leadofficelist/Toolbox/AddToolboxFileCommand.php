<?php namespace Leadofficelist\Toolbox;

class AddToolboxFileCommand {

	public $name;
	public $description;
	public $filename;

	function __construct( $name, $description, $filename ) {

		$this->name        = $name;
		$this->description = $description;
		$this->file         = $filename;
		$this->type        = 'file';
	}

}