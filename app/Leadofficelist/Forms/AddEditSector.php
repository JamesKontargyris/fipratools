<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditSector extends FormValidator {

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'     => 'required|max:255|unique:sectors',
	];

	public $messages = [
	];
} 