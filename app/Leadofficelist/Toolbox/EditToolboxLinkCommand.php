<?php namespace Leadofficelist\Toolbox;

class EditToolboxLinkCommand {

	public $name;
	public $description;
	public $url;
	public $id;

	function __construct( $name, $description, $url, $id ) {

		$this->name        = $name;
		$this->description = $description;
		$this->url         = $url;
		$this->id          = $id;
	}

}