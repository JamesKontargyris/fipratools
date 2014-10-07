<?php namespace Leadofficelist\Sectors;

class Sector extends \BaseModel
{
	protected $fillable = [ 'name' ];
	public $timestamps = false;

	public function add( $sector )
	{
		$this->name = $sector->name;
		$this->save();

		return $this;
	}

	public function edit( $sector )
	{
		$update_sector       = $this->find( $sector->id );
		$update_sector->name = $sector->name;
		$update_sector->save();

		return $update_sector;
	}
}