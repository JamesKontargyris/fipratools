<?php namespace Leadofficelist\Clients;

class CreateClientLinkCommand
{

	public $unit_1;
	public $client_1;
	public $unit_2;
	public $client_2;

	function __construct( $unit_1, $client_1, $unit_2, $client_2 )
	{
		$this->unit_1   = $unit_1;
		$this->client_1 = $client_1;
		$this->unit_2   = $unit_2;
		$this->client_2 = $client_2;
	}


} 