<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditUnitGroup extends FormValidator
{

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	public $rules = [
		'name'       => 'required|max:255|unique:units',
		'short_name' => 'required|max:255|unique:units',
	];

	protected $messages = [
		'short_name.required' => 'Please enter a short name for this group (e.g. UK for United Kingdom).',
	];
} 