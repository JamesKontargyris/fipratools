<?php namespace Leadofficelist\Type_categories;

class EditTypeCategoryCommand
{
    public $name;
    public $short_name;
    public $id;

    function __construct( $name, $short_name, $id )
    {
	    $this->name = trim($name);
        $this->short_name = trim($short_name);
        $this->id   = $id;
    }

}