<?php namespace Leadofficelist\Users;

class EditUserCommand
{

	public $first_name;
	public $last_name;
	public $email;
	public $password;
	public $unit_id;
	public $role_id;
	public $send_email;
	public $id;

	function __construct( $first_name, $last_name, $email, $password, $unit_id, $role_id, $id )
	{

		$this->first_name = $first_name;
		$this->last_name  = $last_name;
		$this->email      = $email;
		$this->password   = $password;
		$this->unit_id    = $unit_id;
		$this->role_id    = $role_id;
		$this->id         = $id;
	}


} 