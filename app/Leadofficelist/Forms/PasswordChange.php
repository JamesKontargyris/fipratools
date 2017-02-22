<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class PasswordChange extends FormValidator {

	protected $rules = [
		'current_password' => 'required|different:new_password',
		'new_password' => 'required|min:6|max:50|confirmed',
		'new_password_confirmation' => 'required'
	];

	protected $messages = [
		'temp_password_match' => 'The current password you entered is incorrect.'
	];

}