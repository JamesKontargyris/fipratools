<?php namespace Leadofficelist\Sector_categories;

class EditSectorCategoryCommand
{
	public $name;
	public $id;

	function __construct( $name, $id )
	{
		$this->name = $name;
		$this->id   = $id;
	}

}