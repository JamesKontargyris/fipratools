<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditClient extends FormValidator
{

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'                => 'required|max:255',
		'pr_client'           => 'numeric',
		'account_director_id' => 'required',
		'sector_id'           => 'required|numeric',
		'type_id'             => 'required|numeric',
		'service_id'          => 'required|numeric',
		'status'              => 'required'
	];

	public $messages = [
		'account_director_id.required' => 'Please select an Account Director (or "none" if applicable for mainly PR clients).',
		'pr_client.numeric'            => 'Please indicate whether this is a PR client or not.',
		'sector_id.required'           => 'Please select a sector.',
		'sector_id.numeric'            => 'Please select a sector.',
		'type_id.required'             => 'Please select a type.',
		'type_id.numeric'              => 'Please select a type.',
		'service_id.required'          => 'Please select a service.',
		'service_id.numeric'           => 'Please select a service.',
	];
}