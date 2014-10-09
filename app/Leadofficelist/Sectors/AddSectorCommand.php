<?php namespace Leadofficelist\Sectors;

class AddSectorCommand
{
	public $name;
	public $category;
	public $new_category;

	function __construct( $name, $category, $new_category )
	{
		$this->name         = $name;
		$this->category     = $category;
		$this->new_category = $new_category;
	}


} 