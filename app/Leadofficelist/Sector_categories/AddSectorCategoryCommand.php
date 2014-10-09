<?php namespace Leadofficelist\Sector_categories;

class AddSectorCategoryCommand
{
	public $name;

	function __construct( $name )
	{
		$this->name = $name;
	}


} 