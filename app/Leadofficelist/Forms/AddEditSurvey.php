<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

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
	];

	public function __construct() {
		foreach(KnowledgeArea::all() as $area) {
			$this->rules[$area->id] = 'required|min:1|max:5';
		}
	}
} 