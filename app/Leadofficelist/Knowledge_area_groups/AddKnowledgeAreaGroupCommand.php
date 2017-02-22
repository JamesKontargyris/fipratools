<?php namespace Leadofficelist\Knowledge_area_groups;

class AddKnowledgeAreaGroupCommand {
	public $name;
	public $description;
	public $order;

	function __construct( $name, $description, $order ) {
		$this->name = trim($name);
		$this->description = trim($description);
		$this->order = trim($order);
	}


}