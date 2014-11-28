<?php namespace Leadofficelist\Client_archives;

class AddClientArchiveCommand
{

	public $date;
	public $unit;
	public $account_director;
	public $comment;
	public $client_id;

	function __construct( $date, $unit, $account_director, $comment, $client_id )
	{

		$this->date = $date;
		$this->unit = $unit;
		$this->account_director = $account_director;
		$this->comment = $comment;
		$this->client_id = $client_id;
	}


} 