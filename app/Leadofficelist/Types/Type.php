<?php namespace Leadofficelist\Types;

class Type extends \BaseModel
{
	protected $fillable = [ 'name' ];
	public $timestamps = false;

	public function add( $type )
	{
		$this->name = $type->name;
		$this->save();

		return $this;
	}

	public function edit( $type )
	{
		$update_type       = $this->find( $type->id );
		$update_type->name = $type->name;
		$update_type->save();

		return $update_type;
	}
}