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
		'date'             => 'required|date',
		'unit'             => 'required|max:255',
		'account_director' => 'required|max:255',
		'comment'          => 'required',
	];

	public $messages = [
		'date.required'             => 'Please enter a date.',
		'date.date'                 => 'Please enter a valid date.',
		'unit.required'             => 'Please enter a Unit name.',
		'account_director.required' => 'Please enter an Account Director\'s name.',
		'comment.required'          => 'Please enter a comment for this archive record.',
	];
} 