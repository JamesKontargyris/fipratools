<?php namespace Leadofficelist\Cases;

class AddCaseCommand {
	public $status;
	public $name;
	public $year;
	public $challenges;
	public $strategy;
	public $result;
	public $unit_id;
	public $account_director_id;
	public $client;
	public $sector_id;
	public $product_id;
	public $user_id;

	function __construct( $status, $name, $year, $challenges, $strategy, $result, $unit_id, $account_director_id, $client_id, $sector_id, $product_id, $user_id ) {

		$this->status              = $status;
		$this->name                = trim( $name );
		$this->year                = trim( $year );
		$this->challenges          = trim( $challenges );
		$this->strategy            = trim( $strategy );
		$this->result              = trim( $result );
		$this->unit_id             = $unit_id;
		$this->account_director_id = $account_director_id;
		$this->client_id              = $client_id;
		$this->sector_id           = (array) $sector_id;
		$this->product_id          = (array) $product_id;
		$this->user_id             = $user_id;
	}


}