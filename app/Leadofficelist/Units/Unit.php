<?php namespace Leadofficelist\Units;

use Eloquent;

class Unit extends Eloquent {

	protected $fillable = ['name'];

	public $timestamps = false;

	public function add($unit)
	{
		$this->name = $unit->name;
		$this->save();

		//$this->raise(new UnitWasAdded($unit));

		return $this;
	}

	public static function getUnitsForFormSelect($blank_entry = false, $prefix = "")
	{
		$units = [];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim($prefix) . ' ';

		if($blank_entry) $units[''] = 'Please select...';

		foreach(Unit::orderBy('name', 'ASC')->get(['id','name']) as $unit)
		{
			$units[$unit->id] = $prefix . $unit->name;
		}

		return $units;
	}

	public function scopeRowsToView($query, $number_of_rows)
	{
		return $query->take($number_of_rows);
	}

	public function scopeRowsSortOrder($query, $sort_on)
	{
		return $query->orderBy($sort_on[0], $sort_on[1]);
	}

}