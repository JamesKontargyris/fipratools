<?php namespace Leadofficelist\Exceptions;

class ResourceNotFoundException extends \Exception
{
	/**
	 * Plural version of the resource name
	 *
	 * @var string
	 */
	private $resource_key;

	function __construct($resource_key)
	{
		parent::__construct();
		$this->resource_key = $resource_key;
	}

	public function getResourceKey()
	{
		return $this->resource_key;
	}

	public function getErrorMessage()
	{
		($this->resource_key == 'sector_categories') ? $key = 'sector category ' : $key = $this->resource_key;
		//Return error message with singular version of resource key
		return 'Sorry, that ' . substr($key, 0, -1) . ' does not exist.';
	}

}