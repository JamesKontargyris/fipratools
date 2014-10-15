<?php namespace Leadofficelist\Exceptions;

class PermissionDeniedException extends \Exception {

	private $resource_key;

	function __construct($resource_key = 'clients')
	{
		parent::__construct();
		$this->resource_key = $resource_key;
	}

	public function getKey()
	{
		return $this->resource_key;
	}

}