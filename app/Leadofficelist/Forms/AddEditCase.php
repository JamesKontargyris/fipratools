<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditCase extends FormValidator {

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'                => 'required',
		'year'                => 'required|date_format:Y',
		'challenges'          => 'required|max:255',
		'strategy'            => 'required|max:255',
		'result'              => 'required|max:255',
		'unit_id'             => 'required|numeric',
		'account_director_id' => 'required',
		'sector_id'           => 'required',
		'product_id'          => 'required'
	];

	public $messages = [
		'name.required'                => 'Please enter a title (an overview of the case study or a client name, if not anonymous).',
		'year.required'                => 'Please enter a year.',
		'year.date_format'             => 'Please enter a valid year in YYYY format.',
		'challenges.required'          => 'Please outline the challenges of this case study.',
		'strategy.required'            => 'Please outline the manner in which Fipra was involved in this case study.',
		'result.required'              => 'Please briefly outline the end result of this case study.',
		'unit_id.required'             => 'Please select a Unit.',
		'unit_id.numeric'              => 'Please select a Unit.',
		'account_director_id.required' => 'Please select an Account Director.',
		'account_director_id.numeric'  => 'Please select an Account Director.',
		'sector_id.required'           => 'Please select a sector.',
		'sector_id.numeric'            => 'Please select a sector.',
		'product_id.required'          => 'Please select at least one product.',
		'product_id.numeric'           => 'Please select at least one product.',
		'max'                          => 'Too many characters. Please reduce the text.'
	];
}