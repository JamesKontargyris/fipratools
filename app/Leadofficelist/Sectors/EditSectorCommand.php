<?php namespace Leadofficelist\Sectors;

class EditSectorCommand
{
	public $name;

	function __construct( $name, $id )
	{
		$this->name = $name;
		$this->id   = $id;
	}

}