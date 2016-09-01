<?php namespace Leadofficelist\Network_types;

class EditNetworkTypeCommand
{

    public $name;

    function __construct( $name, $id )
    {
        $this->name       = trim($name);
        $this->id         = $id;
    }

}