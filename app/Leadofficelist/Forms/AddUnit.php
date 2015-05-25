<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddUnit extends FormValidator {

	/**
	 * Validation rules for adding a unit
	 *
	 * @var array
	 */
	protected $rules = [
		'name'     => 'required|max:255|unique:units',
		'network_type'     => 'required',
		'short_name'     => 'required|max:50|unique:units',
		'address1' => 'required|max:255',
		'address2' => 'max:255',
		'address3' => 'max:255',
		'address4' => 'max:255',
		'postcode' => 'required|max:255',
		'phone'    => 'max:255',
		'fax'      => 'max:255',
		'email'    => 'max:255|email'
	];

	protected $messages = [
		'network_type.required' => 'Please select a Network Member type.',
		'address1.required' => 'The first line of the address is required.'
	];
} 