<?php namespace Leadofficelist\Sectors;

class Sector extends \BaseModel
{
	protected $fillable = [ 'name' ];
	public $timestamps = false;

	public function clients()
	{
		return $this->belongsTo( '\Leadofficelist\Clients\Client', 'id', 'sector_id' );
	}

	public function category()
	{
		return $this->hasOne( '\Leadofficelist\Sector_categories\Sector_category', 'id', 'category_id' );
	}

	public function add( $sector )
	{
		$this->name        = $sector->name;
		$this->category_id = $sector->category_id;
		$this->save();

		return $this;
	}

	public function edit( $sector )
	{
		$update_sector              = $this->find( $sector->id );
		$update_sector->name        = $sector->name;
		$update_sector->category_id = $sector->category_id;
		$update_sector->save();

		return $update_sector;
	}

	public static function getSectorsForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" )
	{
		$sectors = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$sectors[''] = $blank_message;
		}

		foreach ( Sector::orderBy( 'name', 'ASC' )->get( [ 'id', 'name' ] ) as $sector )
		{
			$sectors[ $sector->id ] = $prefix . $sector->name;
		}

		if ( $blank_entry && count( $sectors ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $sectors ) == 0 )
		{
			return false;
		} else
		{
			return $sectors;
		}
	}
}