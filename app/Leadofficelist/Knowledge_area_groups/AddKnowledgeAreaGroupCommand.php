<?php namespace Leadofficelist\Knowledge_area_groups;

class AddKnowledgeAreaGroupCommand {
	public $name;
	public $order;

	function __construct( $name, $order ) {
		$this->name = trim($name);
		$this->order = trim($order);
	}


}