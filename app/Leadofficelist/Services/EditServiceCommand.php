<?php namespace Leadofficelist\Services;

class EditServiceCommand
{
	public $name;

	function __construct( $name, $id )
	{
		$this->name = trim($name);
		$this->id   = $id;
	}

}