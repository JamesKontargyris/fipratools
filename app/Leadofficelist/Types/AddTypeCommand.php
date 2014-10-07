<?php namespace Leadofficelist\Types;

class AddTypeCommand
{
	public $name;

	function __construct($name)
	{
		$this->name = $name;
	}


} 