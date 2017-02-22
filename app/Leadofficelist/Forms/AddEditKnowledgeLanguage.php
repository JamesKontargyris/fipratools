<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditKnowledgeLanguage extends FormValidator {

	/**
	 * Validation rules for adding a service
	 *
	 * @var array
	 */
	public $rules = [
		'name'                    => 'required|max:255|unique:knowledge_languages',
	];

	public $messages = [
		'name.required' => 'Please enter the language.',
		'name.unique' => 'That language already exists.',
	];
} 