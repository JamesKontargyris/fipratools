<?php namespace Leadofficelist\Knowledge_area_groups;

class EditKnowledgeAreaGroupCommand
{
	public $name;
	public $order;

	function __construct( $name, $order, $id )
	{
		$this->name = trim($name);
		$this->order = trim($order);
		$this->id   = $id;
	}

}