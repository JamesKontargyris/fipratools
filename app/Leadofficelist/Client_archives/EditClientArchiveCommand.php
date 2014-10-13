<?php namespace Leadofficelist\Client_archives;

class EditClientArchiveCommand
{
	public $start_date;
	public $end_date;
	public $comment;
	public $id;

	function __construct( $start_date, $end_date, $comment, $id )
	{

		$this->start_date = $start_date;
		$this->end_date   = $end_date;
		$this->comment    = $comment;
		$this->id         = $id;
	}


} 