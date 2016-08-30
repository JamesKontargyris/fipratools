<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditLocation extends FormValidator
{
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'         => 'required|max:255|unique:locations',
	];

	public $messages = [
		'name.unique'         => 'The location name you entered already exists.',
	];
} 