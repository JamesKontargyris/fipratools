<?php namespace Leadofficelist\Unit_groups;

class Unit_group extends \BaseModel
{

    public function unit()
    {
        return $this->hasMany( 'Leadofficelist\Units\Unit' );
    }

    public $timestamps = false;
    public $fillable = ['name', 'short_name'];

    /**
     * Add a new unit group if a new one is passed in,
     * otherwise return the existing one.
     *
     * @param $command
     *
     * @return $this|\Illuminate\Support\Collection|static
     */
    public function add($command)
    {
        $this->name = $command->name;
        $this->short_name = $command->short_name;
        $this->save();

        return $this;
    }

    public function edit($unit_group)
    {
        $update_unit_group = $this->find($unit_group->id);
        $update_unit_group->name = $unit_group->name;
        $update_unit_group->short_name = $unit_group->short_name;
        $update_unit_group->save();

        return $update_unit_group;
    }

}