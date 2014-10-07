<?php namespace Leadofficelist\Units;

class EditUnitCommand {

	public $name;
	public $address1;
	public $address2;
	public $address3;
	public $address4;
	public $postcode;
	public $phone;
	public $fax;
	public $email;

	function __construct( $name, $address1, $address2, $address3, $address4, $postcode, $phone, $fax, $email, $id ) {
		$this->name     = $name;
		$this->address1 = $address1;
		$this->address2 = $address2;
		$this->address3 = $address3;
		$this->address4 = $address4;
		$this->postcode = $postcode;
		$this->phone    = $phone;
		$this->fax      = $fax;
		$this->email    = $email;
		$this->id       = $id;
	}

}