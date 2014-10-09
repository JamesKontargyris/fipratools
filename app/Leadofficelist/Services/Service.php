<?php namespace Leadofficelist\Services;

class Service extends \BaseModel
{
	protected $fillable = ['name'];
	public $timestamps = false;

	public function clients()
	{
		return $this->belongsTo('\Leadofficelist\Clients\Client', 'service_id');
	}

	public function add( $service )
	{
		$this->name = $service->name;
		$this->save();

		return $this;
	}

	public function edit( $service )
	{
		$update_service       = $this->find( $service->id );
		$update_service->name = $service->name;
		$update_service->save();

		return $update_service;
	}

	public static function getServicesForFormSelect( $blank_entry = false, $prefix = "" )
	{
		$services = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$services[''] = 'Please select...';
		}

		foreach ( Service::orderBy( 'name', 'ASC' )->get( [ 'id', 'name' ] ) as $service )
		{
			$services[ $service->id ] = $prefix . $service->name;
		}

		if ( $blank_entry && count( $services ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $services ) == 0 )
		{
			return false;
		} else
		{
			return $services;
		}
	}
}