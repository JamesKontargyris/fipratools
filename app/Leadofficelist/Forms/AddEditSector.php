<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditSector extends FormValidator
{
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'         => 'required|max:255|unique:sectors',
		'category'     => 'required',
		'new_category' => 'required_if:category,new|max:255|unique:sector_categories,name',
	];

	public $messages = [
		'name.unique'         => 'The sector name you entered already exists.',
		'new_category.unique' => 'The sector category you entered already exists.'
	];
} 