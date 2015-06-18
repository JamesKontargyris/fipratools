<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditTypeCategory extends FormValidator
{

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	public $rules = [
		'name'       => 'required|max:255|unique:type_categories',
		'short_name' => 'required|max:255|unique:type_categories',
	];

	protected $messages = [
		'name.required' => 'The reporting category name is required.',
		'short_name.required' => 'Please enter a short name for this category (e.g. NGO for Non-Governmental Organisation).',
	];
} 