<?php

class KnowledgeAreaGroup extends \BaseModel {
	protected $fillable = ['name', 'order'];

	public function add( $group ) {
		$this->name = $group->name;
		$this->order = $group->order;
		$this->save();

		return $this;
	}

	public function edit( $group ) {
		$update_group       = $this->find( $group->id );
		$update_group->name = $group->name;
		$update_group->order = $group->order;
		$update_group->save();

		return $update_group;
	}
}