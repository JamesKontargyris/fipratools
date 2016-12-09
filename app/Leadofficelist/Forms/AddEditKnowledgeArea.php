<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditKnowledgeArea extends FormValidator {

	/**
	 * Validation rules for adding a service
	 *
	 * @var array
	 */
	public $rules = [
		'name'     => 'required|max:255|unique:knowledge_areas',
	];

	public $messages = [
	];
} 