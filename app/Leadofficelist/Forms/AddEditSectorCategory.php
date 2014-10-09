<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditSectorCategory extends FormValidator
{
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'         => 'required|max:255|unique:sector_categories',
	];

	public $messages = [
		'name.unique'         => 'The sector category name you entered already exists.',
	];
} 