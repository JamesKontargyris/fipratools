<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class PasswordReset extends FormValidator {

	/**
	 * Validation rules for logging in a user
	 * @var array
	 */
	protected $rules = [
		'email'     => 'required|email'
	];

}