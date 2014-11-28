<?php namespace Leadofficelist\Client_archives;

use Leadofficelist\Clients\Client;

class ClientArchive extends \Eloquent
{
	protected $fillable = [ 'client_id', 'date', 'unit', 'account_director', 'comment' ];
	public $timestamps = false;

	public function client()
	{
		return $this->hasOne( '\Leadofficelist\Clients\Client', 'id', 'client_id' );
	}

	public function add( $client_archive )
	{
		$this->client_id        = $client_archive->client_id;
		$this->date             = date( "Y-m-d", strtotime( $client_archive->date ) );
		$this->unit             = $client_archive->unit;
		$this->account_director = $client_archive->account_director;
		$this->comment          = $client_archive->comment;
		$this->save();

		return $this;
	}

	public function edit( $client_archive )
	{
		$update_client_archive                   = $this->find( $client_archive->id );
		$update_client_archive->date             = date( "Y-m-d", strtotime( $client_archive->date ) );
		$update_client_archive->unit             = $client_archive->unit;
		$update_client_archive->account_director = $client_archive->account_director;
		$update_client_archive->comment          = $client_archive->comment;
		$update_client_archive->save();

		return $update_client_archive;
	}
}