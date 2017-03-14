<?php namespace Leadofficelist\Forms;

use KnowledgeArea;
use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FactoryInterface as ValidatorFactory;

class AddEditSurvey extends FormValidator
{
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'dob_day' => 'required',
		'dob_month' => 'required',
		'dob_year' => 'required',
		'languages' => 'array|required',
		'expertise_team' => 'array|required',
	];

	public $messages = [
		'languages.required' => 'Please select the languages in which you can conduct business.',
		'expertise_team.required' => 'Please select the team(s) you would place yourself in.',
	];
}