<?php namespace Leadofficelist\Sector_categories;

class Sector_category extends \BaseModel
{
	protected $table = 'sector_categories';
	public $timestamps = false;

	public function sectors()
	{
		return $this->belongsToMany( '\Leadofficelist\Sectors\Sector', 'category_id' );
	}

	/**
	 * Add a new sector category
	 *
	 * @param $command
	 *
	 * @return $this|\Illuminate\Support\Collection|static
	 */
	public function add($command)
	{
		$this->name = $command->name;
		$this->save();

		return $this;
	}

	/**
	 * Add a new sector category if a new one is passed in,
     * otherwise return the existing one.
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function addWithSector($command)
	{
		if($command->category == 'new')
		{
			$this->name = $command->new_category;
			$this->save();

			return $this->id;
		}
		else
		{
			return $command->category;
		}
	}

	public function edit( $sector_category )
	{
		$update_sector_category       = $this->find( $sector_category->id );
		$update_sector_category->name = $sector_category->name;
		$update_sector_category->save();

		return $update_sector_category;
	}

	public static function getSectorCategoriesForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" )
	{
		$sector_categories = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$sector_categories[''] = $blank_message;
		}

		foreach ( Sector_category::orderBy( 'name', 'ASC' )->get( [ 'id', 'name' ] ) as $sector_category )
		{
			$sector_categories[ $sector_category->id ] = $prefix . $sector_category->name;
		}

		if ( $blank_entry && count( $sector_categories ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $sector_categories ) == 0 )
		{
			return false;
		} else
		{
			return $sector_categories;
		}
	}
}