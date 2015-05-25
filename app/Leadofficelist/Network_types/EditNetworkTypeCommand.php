<?php namespace Leadofficelist\Network_types;

class EditNetworkTypeCommand
{

    public $name;

    function __construct( $name, $id )
    {
        $this->name       = $name;
        $this->id         = $id;
    }

}