<?php namespace Leadofficelist\Units;

class EditUnitCommand
{

    public $name;
    public $network_type;
    public $short_name;
    public $address1;
    public $address2;
    public $address3;
    public $address4;
    public $postcode;
    public $phone;
    public $fax;
    public $email;
    public $unit_group;
	public $show_list;
	public $show_case;

	function __construct($name, $network_type, $short_name, $address1, $address2, $address3, $address4, $postcode, $phone, $fax, $email, $unit_group, $show_list, $show_case, $id)
    {
        $this->name = $name;
        $this->network_type = $network_type;
        $this->short_name = $short_name;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->address3 = $address3;
        $this->address4 = $address4;
        $this->postcode = $postcode;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->email = $email;
	    $this->unit_group = $unit_group;
	    $this->show_list = (int)(bool)$show_list;
	    $this->show_case = (int)(bool)$show_case;
	    $this->id = $id;
    }

}