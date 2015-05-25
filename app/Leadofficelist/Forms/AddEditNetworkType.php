<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditNetworkType extends FormValidator
{

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	public $rules = [
		'name'       => 'required|max:255|unique:network_types',
	];

	protected $messages = [
	];
} 