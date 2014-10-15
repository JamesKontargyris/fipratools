<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditClientLink extends FormValidator
{

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'unit_1'   => 'different:unit_2|required|numeric',
		'client_1' => 'different:client_2|required|numeric',
		'unit_2'   => 'required|numeric',
		'client_2' => 'required|numeric',
	];

	public $messages = [
		'unit_1.required'   => 'Please select the first unit.',
		'unit_2.required'   => 'Please select the second unit.',
		'client_1.required' => 'Please select the first client.',
		'client_2.required' => 'Please select the second client.',
		'unit_1.unique'     => 'This link already exists for the first unit.',
		'unit_2.unique'     => 'This link already exists for the second unit.',
		'unit_1.different'     => 'The first unit must be different from the second unit.',
		'client_1.different'     => 'The first client must be different from the second client.',
	];
} 