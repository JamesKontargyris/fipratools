<?php namespace Leadofficelist\Clients;

use App;
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
		return $this->hasOne( '\Leadofficelist\Users\User', 'id', 'user_id' );
	}

	public function unit()
	{
		return $this->hasOne( '\Leadofficelist\Units\Unit', 'id', 'unit_id' );
	}

	public function sector()
	{
		return $this->hasOne( '\Leadofficelist\Sectors\Sector', 'id', 'sector_id' );
	}

	public function type()
	{
		return $this->hasOne( '\Leadofficelist\Types\Type', 'id', 'type_id' );
	}

	public function service()
	{
		return $this->hasOne( '\Leadofficelist\Services\Service', 'id', 'service_id' );
	}

	public function account_director()
	{
		return $this->hasOne( '\Leadofficelist\Account_directors\AccountDirector', 'id', 'account_director_id' );
	}

	public function links()
	{
		return $this->hasMany( '\Leadofficelist\Clients\ClientLink' );
	}

	public function archives()
	{
		return $this->hasMany( '\Leadofficelist\Client_archives\ClientArchive' );
	}

	public function add( $client )
	{
		$this->name                = $client->name;
		$this->account_director_id = $client->account_director_id;
		$this->comments            = $client->comments;
		$this->unit_id             = $client->unit_id;
		$this->user_id             = $client->user_id;
		$this->sector_id           = $client->sector_id;
		$this->type_id             = $client->type_id;
		$this->service_id          = $client->service_id;
		$this->status              = $client->status;
		$this->pr_client           = $client->pr_client;
		$this->save();

		return $this;
	}

	public function edit( $client )
	{
		$update_client                      = $this->find( $client->id );
		$update_client->name                = $client->name;
		$update_client->account_director_id = $client->account_director_id;
		$update_client->comments            = $client->comments;
		$update_client->unit_id             = $client->unit_id;
		$update_client->user_id             = $client->user_id;
		$update_client->sector_id           = $client->sector_id;
		$update_client->type_id             = $client->type_id;
		$update_client->service_id          = $client->service_id;
		$update_client->status              = $client->status;
		$update_client->pr_client           = $client->pr_client;
		$update_client->save();

		return $update_client;
	}

	/**
	 * Change a client's status
	 *
	 * @param $id
	 * @param $status
	 *
	 * @return bool
	 */
	public function updateStatus($id, $status)
	{
		//Ensure $status is an integer, either 1 or 0
		$status = ($status == 1 || strtolower($status) == 'active') ? 1 : 0;
		//Set $status_text as the wording equivalent
		$status_text = ($status == 1) ? 'Active' : 'Dormant';
		//Get the client using $id
		$client = $this->where('id', '=', $id)->first();

		//If the client status is different...
		if($client->status != $status)
		{
			//Update the status and save the model
			$client->status = $status;
			$client->save();

			return true;
		}

		return false;
	}

	public function getLeadOfficeAddress()
	{
		return Unit::addressMultiLine( $this->unit_id );
	}

	public function getLinkedUnits( $id )
	{
		$links = ClientLink::where( 'client_id', '=', $id )->get();
		$units = [ ];

		foreach ( $links as $link )
		{
			$units[] = Unit::find( $link->unit()->pluck( 'id' ) );
		}

		return $units;
	}

	/**
	 * Return a nicely formatted list of unit short names
	 * for display on the client overview page
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public function getLinkedUnitsList( $id )
	{
		$links      = ClientLink::where( 'client_id', '=', $id )->get();
		$unit_names = [ ];

		foreach ( $links as $link )
		{
			$unit_names[] = $link->unit()->pluck( 'short_name' );
		}

		return pretty_links_list( $unit_names );
	}
}