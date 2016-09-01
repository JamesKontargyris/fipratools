<?php namespace Leadofficelist\Products;

class EditProductCommand
{
	public $name;

	function __construct( $name, $id )
	{
		$this->name = trim($name);
		$this->id   = $id;
	}

}