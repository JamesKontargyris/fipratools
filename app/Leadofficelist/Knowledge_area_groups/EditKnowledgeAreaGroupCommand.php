<?php namespace Leadofficelist\Knowledge_area_groups;

class EditKnowledgeAreaGroupCommand
{
	public $name;
	public $description;
	public $order;

	function __construct( $name, $description, $order, $id )
	{
		$this->name = trim($name);
		$this->description = trim($description);
		$this->order = trim($order);
		$this->id   = $id;
	}

}