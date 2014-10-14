<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditType extends FormValidator
{

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'       => 'required|max:255|unique:types',
		'short_name' => 'required|max:255|unique:types',
	];

	public $messages = [
	];
} 