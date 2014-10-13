<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditClientArchive extends FormValidator
{

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'start_date' => 'required|date',
		'end_date'   => 'required|date',
		'comment'    => 'required',
	];

	public $messages = [
		'start_date.required' => 'Please enter a start date.',
		'start_date.date'     => 'Please enter a valid start date.',
		'end_date.required'   => 'Please enter an end date.',
		'end_date.date'       => 'Please enter a valid end date.',
		'comment.required'    => 'Please enter details for this archive record.',
	];
} 