<?php namespace Leadofficelist\Client_archives;

use Leadofficelist\Clients\Client;

class ClientArchive extends \Eloquent
{
	protected $fillable = [ 'client_id', 'start_date', 'end_date', 'comment' ];
	public $timestamps = false;

	public function client()
	{
		return $this->hasOne( '\Leadofficelist\Clients\Client', 'id', 'client_id' );
	}

	public function add( $client_archive )
	{
		$this->client_id  = $client_archive->client_id;
		$this->start_date = date( "Y-m-d", strtotime( $client_archive->start_date ) );
		$this->end_date   = date( "Y-m-d", strtotime( $client_archive->end_date ) );
		$this->comment    = $client_archive->comment;
		$this->save();

		return $this;
	}

	public function edit( $client_archive )
	{
		$update_client_archive             = $this->find( $client_archive->id );
		$update_client_archive->start_date = date( "Y-m-d", strtotime( $client_archive->start_date ) );
		$update_client_archive->end_date   = date( "Y-m-d", strtotime( $client_archive->end_date ) );
		$update_client_archive->comment    = $client_archive->comment;
		$update_client_archive->save();

		return $update_client_archive;
	}
}