<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddUser extends FormValidator {

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	protected $rules = [
		'first_name' => 'required|max:255',
		'last_name' => 'required|max:255',
		'email' => 'required|email|max:255|unique:users',
		'password' => 'required|confirmed|min:6|max:12',
		'unit_id' => 'required|numeric',
		'role_id' => 'required|numeric'
	];

	protected $messages = [
		'role.required' => 'Please select a role for this user.',
		'unit_id.required' => 'Please link this user to a Fipra unit.',
		'email.unique' => 'User with this email address already exists.',
	];
} 