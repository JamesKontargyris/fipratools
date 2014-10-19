<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditAccountDirector extends FormValidator
{
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'first_name' => 'required|max:255',
		'last_name'  => 'required:max:255',
	];

	public $messages = [
		'first_name.required' => 'Please enter the AD\'s first name.',
		'last_name.required'  => 'Please enter the AD\'s last name.',
		'first_name.max'      => 'Please enter a first name no longer than 255 characters in length.',
		'last_name.max'       => 'Please enter a last name no longer than 255 characters in length.',
		'first_name.unique'   => 'That name is already taken.',
	];
} 