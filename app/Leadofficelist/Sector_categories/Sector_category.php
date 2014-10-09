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
	 * Add a new sector category if a new one is passed in,
	 * otherwise return the existing one.
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
	 * Add a sector category when a sector is added
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
}