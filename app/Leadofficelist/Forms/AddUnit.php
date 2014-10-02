<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddUnit extends FormValidator {

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	protected $rules = [
		'name' => 'required|max:255|unique:units'
	];
} 