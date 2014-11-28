<?php namespace Leadofficelist\Clients;

class EditClientStatusCommand
{

	public $clients;

	function __construct( $clients )
	{

		$this->clients = $clients;
	}


} 