<?php namespace Leadofficelist\Services;

class Service extends \BaseModel
{
	protected $fillable = ['name'];
	public $timestamps = false;

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
}