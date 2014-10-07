<?php namespace Leadofficelist\Units;

class Unit extends \BaseModel
{

	protected $fillable = [ 'name' ];

	public $timestamps = false;

	public function users()
	{
		return $this->hasMany( 'Leadofficelist\Users\User' );
	}

	public function add( $unit )
	{
		$this->name      = $unit->name;
		$this->address1  = $unit->address1;
		$this->address2  = $unit->address2;
		$this->address3  = $unit->address3;
		$this->address4  = $unit->address4;
		$this->post_code = $unit->postcode;
		$this->phone     = $unit->phone;
		$this->fax       = $unit->fax;
		$this->email     = $unit->email;
		$this->save();

		return $this;
	}

	public function edit( $unit )
	{
		$update_unit = $this->find( $unit->id );
		//$this->name     = $unit->name;
		$update_unit->address1  = $unit->address1;
		$update_unit->address2  = $unit->address2;
		$update_unit->address3  = $unit->address3;
		$update_unit->address4  = $unit->address4;
		$update_unit->post_code = $unit->postcode;
		$update_unit->phone     = $unit->phone;
		$update_unit->fax       = $unit->fax;
		$update_unit->email     = $unit->email;
		$update_unit->save();

		//$this->raise(new UnitWasAdded($unit));

		return $update_unit;
	}


	public static function getUnitsForFormSelect( $blank_entry = false, $prefix = "" )
	{
		$units = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';

		if ( $blank_entry )
		{
			$units[''] = 'Please select...';
		}

		foreach ( Unit::orderBy( 'name', 'ASC' )->get( [ 'id', 'name' ] ) as $unit )
		{
			$units[ $unit->id ] = $prefix . $unit->name;
		}

		return $units;
	}

	public function addressOneLine()
	{
		$address = '';
		$address .= $this->address1;
		if ( $this->address2 != '' )
		{
			$address .= ', ' . $this->address2;
		}
		if ( $this->address3 != '' )
		{
			$address .= ', ' . $this->address3;
		}
		if ( $this->address4 != '' )
		{
			$address .= ', ' . $this->address4;
		}
		if ( $this->post_code != '' )
		{
			$address .= ', ' . $this->post_code;
		}

		return $address;
	}
}