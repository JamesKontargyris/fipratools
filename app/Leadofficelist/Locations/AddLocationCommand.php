<?php namespace Leadofficelist\Locations;

class AddLocationCommand {
	public $name;

	function __construct( $name ) {
		$this->name = $name;
	}


}