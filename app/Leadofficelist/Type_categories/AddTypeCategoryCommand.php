<?php namespace Leadofficelist\Type_categories;

class AddTypeCategoryCommand
{
	public $name;
	public $short_name;
    public $type_category;

	function __construct( $name, $short_name, $type_category )
	{
		$this->name = $name;
		$this->short_name = $short_name;
        $this->type_category = $type_category;
	}


} 