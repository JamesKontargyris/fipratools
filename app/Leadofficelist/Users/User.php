<?php namespace Leadofficelist\Users;

use Eloquent;
use Hash;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	//DB Relationships
	public function unit()
	{
		//One user belongs to one unit
		return $this->belongsTo('units');
	}

	public function getFirstNameAttribute($value)
	{
		return ucfirst($value);
	}

	public function getLastNameAttribute($value)
	{
		return ucfirst($value);
	}

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	public function add($user)
	{
		$this->first_name = $user->first_name;
		$this->last_name = $user->last_name;
		$this->email = $user->email;
		$this->password = $user->password;
		$this->unit_id = $user->unit_id;
		$this->save();

		return $this;
	}

	public static function getFullName($user)
	{
		return $user->first_name . ' ' . $user->last_name;
	}

}
