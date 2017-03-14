<?php namespace Leadofficelist\Users;

use Eloquent;
use Hash;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

class User extends \BaseModel implements UserInterface, RemindableInterface
{

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array( 'password', 'remember_token' );

	public function unit()
	{
		//One user belongs to one unit
		return $this->belongsTo( '\Leadofficelist\Units\Unit', 'unit_id' );
	}

	public function clients()
	{
		//One user belongs to one unit
		return $this->hasMany( '\Leadofficelist\Clients\Client' );
	}

	public function knowledge_areas()
	{
		//Many users have many knowledge areas
		return $this->belongsToMany( '\Leadofficelist\Knowledge_areas\KnowledgeArea' )->withPivot('score');
	}

	public function knowledge_languages()
	{
		//Many users have many knowledge languages
		return $this->belongsToMany( '\Leadofficelist\Knowledge_languages\KnowledgeLanguage' );
	}

	public function getFirstNameAttribute( $value )
	{
		return ucfirst( $value );
	}

	public function getLastNameAttribute( $value )
	{
		return ucfirst( $value );
	}

	public function setPasswordAttribute( $value )
	{
		$this->attributes['password'] = Hash::make( $value );
	}

	public function add( $user )
	{
		$this->first_name = $user->first_name;
		$this->last_name  = $user->last_name;
		$this->email      = $user->email;
		$this->password   = $user->password;
		$this->unit_id    = $user->unit_id;
		$this->save();

		return $this;
	}

	public function updateUserKnowledgeInfo( $user )
	{
		$update_user = $this->find($user->id);
		$update_user->date_of_birth = $user->dob_year . '-' . $user->dob_month . '-' . $user->dob_day;
		$update_user->survey_updated    = 1;
		$update_user->knowledge_profile_last_updated = date('Y-m-d');
		$update_user->save();

		return $update_user;
	}

	public function edit( $user )
	{
		$update_user             = $this->find( $user->id );
		$update_user->detachRole($update_user->roles()->pluck('roles.id'));
		$update_user->attachRole($user->role_id);

		$update_user->first_name = $user->first_name;
		$update_user->last_name  = $user->last_name;
		$update_user->email      = $user->email;
		$update_user->unit_id    = $user->unit_id;

		if ( $user->password )
		{
			$update_user->password = $user->password;
		}

		$update_user->save();

		return $update_user;
	}

	public function getFullName( $reversed = false )
	{
		if ( $reversed )
		{
			return $this->last_name . ', ' . $this->first_name;
		} else
		{
			return $this->first_name . ' ' . $this->last_name;
		}
	}

	public function getUnit()
	{
		return $this->unit;
	}

}
