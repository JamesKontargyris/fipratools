<?php namespace Leadofficelist\Exceptions;

class ProfileNotFoundException extends \Exception
{
	function __construct()
	{
		parent::__construct();
	}

	public function getErrorMessage()
	{
		//Return error message with singular version of resource key
		return 'Sorry, that profile does not exist.';
	}

}