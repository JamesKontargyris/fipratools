<?php namespace Leadofficelist\Locations;

class EditLocationCommand
{
	public $name;

	function __construct( $name, $id )
	{
		$this->name = $name;
		$this->id   = $id;
	}

}