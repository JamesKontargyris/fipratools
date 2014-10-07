<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditService extends FormValidator {

	/**
	 * Validation rules for adding a service
	 *
	 * @var array
	 */
	public $rules = [
		'name'     => 'required|max:255|unique:services',
	];

	public $messages = [
	];
} 