<?php namespace Leadofficelist\Network_types;

class AddNetworkTypeCommand
{

    public $name;

    function __construct( $name )
    {

        $this->name       = $name;
    }


}