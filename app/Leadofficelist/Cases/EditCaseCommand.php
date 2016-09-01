<?php namespace Leadofficelist\Cases;

class EditCaseCommand {
	public $name;
	public $year;
	public $challenges;
	public $strategy;
	public $result;
	public $unit_id;
	public $account_director_id;
	public $sector_id;
	public $product_id;
	public $user_id;

	function __construct( $name, $year, $challenges, $strategy, $result, $unit_id, $account_director_id, $sector_id, $product_id, $user_id, $id ) {

		$this->name                = trim($name);
		$this->year                = trim($year);
		$this->challenges          = trim($challenges);
		$this->strategy            = trim($strategy);
		$this->result              = trim($result);
		$this->unit_id             = $unit_id;
		$this->account_director_id = $account_director_id;
		$this->sector_id           = $sector_id;
		$this->product_id          = $product_id;
		$this->user_id             = $user_id;
		$this->id                  = $id;
	}


}