<?php namespace Leadofficelist\Unit_groups;

class AddUnitGroupCommand
{
	public $name;
	public $short_name;

	function __construct( $name, $short_name )
	{
		$this->name = $name;
		$this->short_name = $short_name;
	}


} 