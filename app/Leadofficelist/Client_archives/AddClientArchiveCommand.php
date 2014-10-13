<?php namespace Leadofficelist\Client_archives;

class AddClientArchiveCommand
{
	public $start_date;
	public $end_date;
	public $comment;
	public $client_id;

	function __construct( $start_date, $end_date, $comment, $client_id )
	{

		$this->start_date = $start_date;
		$this->end_date   = $end_date;
		$this->comment    = $comment;
		$this->client_id  = $client_id;
	}


} 