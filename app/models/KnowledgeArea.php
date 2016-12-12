<?php

class KnowledgeArea extends \BaseModel {
	protected $fillable = ['name', 'knowledge_area_group_id'];

	public function add( $area ) {
		$this->name = $area->name;
		$this->knowledge_area_group_id = $area->knowledge_area_group_id;
		$this->save();

		return $this;
	}

	public function edit( $area ) {
		$update_area       = $this->find( $area->id );
		$update_area->name = $area->name;
		$update_area->knowledge_area_group_id = $area->knowledge_area_group_id;
		$update_area->save();

		return $update_area;
	}
}