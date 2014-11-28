<?php namespace Leadofficelist\Client_archives;

class EditClientArchiveCommand
{

	public $date;
	public $unit;
	public $account_director;
	public $comment;
	public $id;

	function __construct( $date, $unit, $account_director, $comment, $id )
	{

		$this->date             = $date;
		$this->unit             = $unit;
		$this->account_director = $account_director;
		$this->comment          = $comment;
		$this->id               = $id;
	}


} 