<?php namespace Leadofficelist\Products;

class AddProductCommand {
	public $name;

	function __construct( $name ) {
		$this->name = $name;
	}


}