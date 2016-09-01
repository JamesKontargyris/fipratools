<?php namespace Leadofficelist\Types;

class EditTypeCommand
{
    public $name;
    public $short_name;
    public $type_category;
    public $id;

    function __construct($name, $short_name, $type_category, $id)
    {
	    $this->name = trim($name);
	    $this->short_name = trim($short_name);
        $this->type_category = $type_category;
        $this->id = $id;
    }

}