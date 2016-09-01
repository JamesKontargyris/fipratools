<?php namespace Leadofficelist\Account_directors;

class AddAccountDirectorCommand
{
	public $first_name;
	public $last_name;
	public $show_list;
	public $show_case;

	function __construct( $first_name, $last_name, $show_list, $show_case )
	{
		$this->first_name = trim($first_name);
		$this->last_name = trim($last_name);
		$this->show_list = (int)(bool)$show_list;
		$this->show_case = (int)(bool)$show_case;
	}
}