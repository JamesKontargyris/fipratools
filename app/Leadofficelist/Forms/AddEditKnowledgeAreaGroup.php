<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditKnowledgeAreaGroup extends FormValidator {

	/**
	 * Validation rules for adding a service
	 *
	 * @var array
	 */
	public $rules = [
		'name'     => 'required|max:255|unique:knowledge_area_groups',
		'order'     => 'required|integer',
	];

	public $messages = [
	];
} 