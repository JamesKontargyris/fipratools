<?php namespace Leadofficelist\Types;

class AddTypeCommand
{
	public $name;
	public $short_name;

	function __construct($name, $short_name)
	{
		$this->name = $name;
		$this->short_name = $short_name;
	}


} 