<?php namespace Leadofficelist\Knowledge_areas;

use Leadofficelist\Users\User;

class KnowledgeArea extends \BaseModel {
	protected $fillable = ['name', 'knowledge_area_group_id'];

	public function users()
	{
		//Many users have many knowledge areas
		return $this->belongsToMany( '\Leadofficelist\Users\User' )->withPivot('score');
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

	public static function getKnowledgeAreasForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" )
	{
		$areas = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the area name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$areas[''] = $blank_message;
		}

		foreach (
			KnowledgeArea::orderBy( 'name', 'ASC' )->get( [
				'id',
				'name'
			] ) as $area
		)
		{
			$areas[ $area->id ] = $prefix . $area->name;
		}



		if ( $blank_entry && count( $areas ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $areas ) == 0 )
		{
			return false;
		} else
		{
			return $areas;
		}
	}
}