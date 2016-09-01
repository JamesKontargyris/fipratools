<?php namespace Leadofficelist\Units;

class AddUnitCommand {

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

	function __construct( $name, $network_type, $short_name, $address1, $address2, $address3, $address4, $postcode, $phone, $fax, $email, $unit_group, $show_list, $show_case ) {

		$this->name         = trim($name);
		$this->network_type = $network_type;
		$this->short_name   = trim($short_name);
		$this->address1     = trim($address1);
		$this->address2     = trim($address2);
		$this->address3     = trim($address3);
		$this->address4     = trim($address4);
		$this->postcode     = trim($postcode);
		$this->phone        = trim($phone);
		$this->fax          = trim($fax);
		$this->email        = trim($email);
		$this->unit_group   = $unit_group;
		$this->show_list    = (int) (bool) $show_list;
		$this->show_case    = (int) (bool) $show_case;
	}


} 