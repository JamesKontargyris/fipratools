<?php namespace Leadofficelist\Knowledge_areas;

class EditKnowledgeAreaCommand
{
	public $name;
	public $knowledge_area_group_id;

	function __construct( $name, $knowledge_area_group_id, $id )
	{
		$this->name = trim($name);
		$this->knowledge_area_group_id = $knowledge_area_group_id;
		$this->id   = $id;
	}

}