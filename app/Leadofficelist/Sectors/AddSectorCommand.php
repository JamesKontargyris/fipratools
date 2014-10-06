<?php namespace Leadofficelist\Sectors;

class AddSectorCommand
{
	public $name;

	function __construct($name)
	{
		$this->name = $name;
	}


} 