<?php namespace Leadofficelist\Account_directors;

class AccountDirector extends \BaseModel
{
	protected $fillable = [ 'first_name', 'last_name' ];
	public $timestamps = false;

	public function clients()
	{
		return $this->belongsTo( 'Leadofficelist\Clients\Client', 'id', 'account_director_id' );
	}

	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function add( $account_director )
	{
		$this->first_name = $account_director->first_name;
		$this->last_name  = $account_director->last_name;
		$this->save();

		return $this;
	}

	public function edit( $account_director )
	{
		$update_account_director             = $this->find( $account_director->id );
		$update_account_director->first_name = $account_director->first_name;
		$update_account_director->last_name  = $account_director->last_name;
		$update_account_director->save();

		return $update_account_director;
	}

	public static function getAccountDirectorsForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" )
	{
		$ads = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$ads[''] = $blank_message;
		}

		foreach (
			AccountDirector::orderBy( 'last_name', 'ASC' )->get( [
				'id',
				'first_name',
				'last_name'
			] ) as $account_director
		)
		{
			$ads[ $account_director->id ] = $prefix . $account_director->first_name . ' ' . $account_director->last_name;
		}



		if ( $blank_entry && count( $ads ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $ads ) == 0 )
		{
			return false;
		} else
		{
			return $ads;
		}
	}
}