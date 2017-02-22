<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditWidget extends FormValidator
{
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'         => 'required|max:255|unique:widgets',
		'slug'         => 'required|max:50|unique:widgets',
	];

	public $messages = [
		'name.unique'         => 'The widget name you entered already exists.',
		'slug.unique'         => 'The slug name you entered already exists.',
	];
} 