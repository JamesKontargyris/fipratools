<?php namespace Leadofficelist\Account_directors;

class EditAccountDirectorCommand
{
	public $first_name;
	public $last_name;
	public $id;

	function __construct( $first_name, $last_name, $id )
	{
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->id = $id;
	}
}