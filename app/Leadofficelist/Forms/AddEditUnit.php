<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditUnit extends FormValidator
{

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	public $rules = [
		'name'       => 'required|max:255|unique:units',
		'short_name' => 'required|max:255|unique:units',
		'address1'   => 'required|max:255',
		'address2'   => 'max:255',
		'address3'   => 'max:255',
		'address4'   => 'max:255',
		'phone'      => 'max:255',
		'fax'        => 'max:255',
		'email'      => 'max:255|email'
	];

	protected $messages = [
		'short_name.required' => 'Please enter a short name for this unit (e.g. UK for United Kingdom).',
		'address1.required'   => 'The first line of the address is required.'
	];
} 