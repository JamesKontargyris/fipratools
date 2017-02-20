<?php namespace Leadofficelist\Knowledge_areas;

use Leadofficelist\Users\User;

class KnowledgeArea extends \BaseModel {
	protected $fillable = ['name', 'knowledge_area_group_id'];

	public function users()
	{
		//Many users have many knowledge areas
		return $this->belongsToMany( '\Leadofficelist\Users\User' );
	}

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

	public function updateKnowledgeAreaInfo( $areas ) {
		$update_user = User::find( $areas->id );
		$area_ids = array_keys($areas->areas);
		// Create an array of ids and scores for each area to add in to the pivot table
		$sync_data   = [];
		foreach ( $area_ids as $area_id ) {
			$sync_data[ $area_id ] = [ 'score' => $areas->areas[$area_id] ];
		}
		$update_user->knowledge_areas()->sync($sync_data);

		return $update_user;
	}
}