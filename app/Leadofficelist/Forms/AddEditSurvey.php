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
		'joined_fipra_day' => 'required',
		'joined_fipra_month' => 'required',
		'joined_fipra_year' => 'required',
		'total_fipra_working_time' => 'required|numeric|min:0|max:100',
		'languages' => 'array|required',
		'fluent' => 'array|required'
	];

	public $messages = [
		'total_fipra_working_time.numeric' => 'Please enter your total Fipra working time as a percentage.',
		'total_fipra_working_time.max' => 'Please enter your total Fipra working time as a percentage.',
		'total_fipra_working_time.min' => 'Please enter your total Fipra working time as a percentage.',
		'languages.required' => 'Please select the languages you speak / write.',
		'fluent.required' => 'Please select the languages in which you are fluent.',
	];
}