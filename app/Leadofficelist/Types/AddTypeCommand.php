<?php namespace Leadofficelist\Types;

class AddTypeCommand
{
	public $name;
	public $short_name;
    public $type_category;

    function __construct($name, $short_name, $type_category)
	{
		$this->name = trim($name);
		$this->short_name = trim($short_name);
        $this->type_category = $type_category;
    }


} 