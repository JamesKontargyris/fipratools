<?php namespace Leadofficelist\Types;

class EditTypeCommand
{
	public $name;

	function __construct( $name, $id )
	{
		$this->name = $name;
		$this->id   = $id;
	}

}