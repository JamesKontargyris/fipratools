<?php namespace Leadofficelist\Clients;

use Leadofficelist\Units\Unit;

class Client extends \BaseModel
{
	protected $fillable = [
		'name',
		'account_director',
		'comments',
		'unit_id',
		'user_id',
		'sector_id',
		'type_id',
		'service_id',
		'status'
	];

	public function user()
	{
		return $this->hasOne('\Leadofficelist\Users\User', 'id', 'user_id');
	}

	public function unit()
	{
		return $this->hasOne('\Leadofficelist\Units\Unit', 'id', 'unit_id');
	}

	public function sector()
	{
		return $this->hasOne('\Leadofficelist\Sectors\Sector', 'id', 'sector_id');
	}

	public function type()
	{
		return $this->hasOne('\Leadofficelist\Types\Type', 'id', 'type_id');
	}

	public function service()
	{
		return $this->hasOne('\Leadofficelist\Services\Service', 'id', 'service_id');
	}

	public function add( $client )
	{
		$this->name             = $client->name;
		$this->account_director = $client->account_director;
		$this->comments         = $client->comments;
		$this->unit_id          = $client->unit_id;
		$this->user_id          = $client->user_id;
		$this->sector_id        = $client->sector_id;
		$this->type_id          = $client->type_id;
		$this->service_id       = $client->service_id;
		$this->status           = $client->status;
		$this->save();

		return $this;
	}

	public function edit( $client )
	{
		$update_client                   = $this->find( $client->id );
		$update_client->name             = $client->name;
		$update_client->account_director = $client->account_director;
		$update_client->comments         = $client->comments;
		$update_client->unit_id          = $client->unit_id;
		$update_client->user_id          = $client->user_id;
		$update_client->sector_id        = $client->sector_id;
		$update_client->type_id          = $client->type_id;
		$update_client->service_id       = $client->service_id;
		$update_client->status           = $client->status;
		$update_client->save();

		return $update_client;
	}

	public function getLeadOfficeAddress()
	{
		return Unit::addressMultiLine($this->unit_id);
	}
}