<?php namespace Leadofficelist\Units;

class Unit extends \BaseModel
{

    protected $fillable = ['name'];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany('Leadofficelist\Users\User');
    }

    public function clients()
    {
        return $this->hasMany('Leadofficelist\Clients\Client');
    }

    public function links()
    {
        return $this->hasMany('Leadofficelist\Clients\ClientLink');
    }

    public function unit_group()
    {
        return $this->belongsTo('Leadofficelist\Unit_groups\Unit_group');
    }

    public function network_type()
    {
        return $this->belongsTo('Leadofficelist\Network_types\Network_type');
    }

    public function add($unit)
    {
        $this->name = $unit->name;
        $this->short_name = $unit->short_name;
        $this->address1 = $unit->address1;
        $this->address2 = $unit->address2;
        $this->address3 = $unit->address3;
        $this->address4 = $unit->address4;
        $this->post_code = $unit->postcode;
        $this->phone = $unit->phone;
        $this->fax = $unit->fax;
        $this->email = $unit->email;
        $this->unit_group_id = $unit->unit_group;
        $this->save();

        return $this;
    }

    public function edit($unit)
    {
        $update_unit = $this->find($unit->id);
        $update_unit->name = $unit->name;
        $update_unit->short_name = $unit->short_name;
        $update_unit->address1 = $unit->address1;
        $update_unit->address2 = $unit->address2;
        $update_unit->address3 = $unit->address3;
        $update_unit->address4 = $unit->address4;
        $update_unit->post_code = $unit->postcode;
        $update_unit->phone = $unit->phone;
        $update_unit->fax = $unit->fax;
        $update_unit->email = $unit->email;
        $update_unit->unit_group_id = $unit->unit_group;
        $update_unit->save();

        //$this->raise(new UnitWasAdded($unit));

        return $update_unit;
    }


    public static function getUnitsForFormSelect($blank_entry = false, $blank_message = 'Please select...', $prefix = "")
    {
        $units = [];
        //Remove whitespace from $prefix and add a space on the end, so there is a space
        //between the prefix and the unit name
        $prefix = trim($prefix) . ' ';
        //If $blank_entry == true, add a blank "Please select..." option
        if ($blank_entry) {
            $units[''] = $blank_message;
        }

        foreach (Unit::orderBy('name', 'ASC')->get(['id', 'name']) as $unit) {
            $units[$unit->id] = $prefix . $unit->name;
        }

        if ($blank_entry && count($units) == 1) {
            return false;
        }
        elseif (!$blank_entry && count($units) == 0) {
            return false;
        }
        else {
            return $units;
        }
    }

    public function addressOneLine()
    {
        $address = '';
        $address .= $this->address1;
        if ($this->address2 != '') {
            $address .= ', ' . $this->address2;
        }
        if ($this->address3 != '') {
            $address .= ', ' . $this->address3;
        }
        if ($this->address4 != '') {
            $address .= ', ' . $this->address4;
        }
        if ($this->post_code != '') {
            $address .= ', ' . $this->post_code;
        }

        return $address;
    }

    public static function addressMultiLine($unit_id)
    {
        $lead_office = Unit::find($unit_id);

        $address = '';
        $address .= $lead_office->address1;
        if ($lead_office->address2 != '') {
            $address .= '<br/>' . $lead_office->address2;
        }
        if ($lead_office->address3 != '') {
            $address .= '<br/>' . $lead_office->address3;
        }
        if ($lead_office->address4 != '') {
            $address .= '<br/>' . $lead_office->address4;
        }
        if ($lead_office->post_code != '') {
            $address .= '<br/>' . $lead_office->post_code;
        }

        return $address;
    }
}