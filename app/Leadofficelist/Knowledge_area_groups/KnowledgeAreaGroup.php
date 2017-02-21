<?php namespace Leadofficelist\Knowledge_area_groups;

class KnowledgeAreaGroup extends \BaseModel {
	protected $fillable = [ 'name', 'order' ];

	public function add( $group ) {
		$this->name        = $group->name;
		$this->description = $group->description;
		$this->order       = $group->order;
		$this->save();

		return $this;
	}

	public function edit( $group ) {
		$update_group              = $this->find( $group->id );
		$update_group->name        = $group->name;
		$update_group->description = $group->description;
		$update_group->order       = $group->order;
		$update_group->save();

		return $update_group;
	}
}