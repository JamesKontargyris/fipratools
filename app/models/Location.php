<?php

class Location extends \BaseModel {
	protected $fillable = [ 'name' ];
	public $timestamps = false;

	public static function getLocationsForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" ) {
		$locations = [];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry ) {
			$locations[''] = $blank_message;
		}

		foreach (
			Product::orderBy( 'name', 'ASC' )->get( [
				'id',
				'name'
			] ) as $location
		) {
			$locations[ $location->id ] = $prefix . $location->name;
		}


		if ( $blank_entry && count( $locations ) == 1 ) {
			return false;
		} elseif ( ! $blank_entry && count( $locations ) == 0 ) {
			return false;
		} else {
			return $locations;
		}
	}

	public function add( $location ) {
		$this->name = $location->name;
		$this->save();

		return $this;
	}

	public function edit( $location ) {
		$update_location       = $this->find( $location->id );
		$update_location->name = $location->name;
		$update_location->save();

		return $update_location;
	}
}