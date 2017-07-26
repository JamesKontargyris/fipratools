<?php namespace Leadofficelist\Users;

class EditUserCommand {

	public $first_name;
	public $last_name;
	public $email;
	public $password;
	public $unit_id;
	public $role_id;
	public $send_email;
	public $forum_access;
	public $id;

	function __construct( $first_name, $last_name, $email, $password, $unit_id, $role_id, $forum_access = 0, $id ) {

		$this->first_name   = trim( $first_name );
		$this->last_name    = trim( $last_name );
		$this->email        = trim( $email );
		$this->password     = $password;
		$this->unit_id      = $unit_id;
		$this->role_id      = $role_id;
		$this->id           = $id;
		$this->forum_access = (int)(bool)$forum_access;
	}


} 