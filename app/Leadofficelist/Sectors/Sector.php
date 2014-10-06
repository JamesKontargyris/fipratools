<?php namespace Leadofficelist\Sectors;

class Sector extends \Eloquent
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

	public function scopeRowsToView( $query, $number_of_rows )
	{
		return $query->take( $number_of_rows );
	}

	public function scopeRowsSortOrder( $query, $sort_on )
	{
		return $query->orderBy( $sort_on[0], $sort_on[1] );
	}
}