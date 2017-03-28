<?php namespace Leadofficelist\Toolbox;

class AddToolboxLinkCommand {

	public $name;
	public $description;
	public $url;

	function __construct( $name, $description, $url ) {

		$this->name        = $name;
		$this->description = $description;
		$this->url         = $url;
		$this->type        = 'link';
	}

}