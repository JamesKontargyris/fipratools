<?php namespace Leadofficelist\Network_types;

class Network_type extends \BaseModel
{
    protected $fillable = ['network_type'];
    public $timestamps = false;

    public function units()
    {
        return $this->hasMany('Leadofficelist\Units\Unit');
    }

    public function add($network_type)
    {
        $this->name = $network_type->name;
        $this->save();

        return $this;
    }

    public function edit($network_type)
    {
        $update_network_type = $this->find($network_type->id);
        $update_network_type->name = $network_type->name;
        $update_network_type->save();

        //$this->raise(new UnitWasAdded($network_type));

        return $update_network_type;
    }
}