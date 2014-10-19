<?php namespace Leadofficelist\Clients;

class AddClientCommand
{
	public $name;
	public $account_director_id;
	public $comments;
	public $unit_id;
	public $user_id;
	public $sector_id;
	public $type_id;
	public $service_id;
	public $status;
	public $pr_client;

	function __construct( $name, $account_director_id, $comments, $unit_id, $user_id, $sector_id, $type_id, $service_id, $status, $pr_client )
	{

		$this->name                = $name;
		$this->account_director_id = $account_director_id;
		$this->comments            = $comments;
		$this->unit_id             = $unit_id;
		$this->user_id             = $user_id;
		$this->sector_id           = $sector_id;
		$this->type_id             = $type_id;
		$this->service_id          = $service_id;
		$this->status              = $status;
		$this->pr_client           = $pr_client;
	}


} 