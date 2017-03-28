<?php namespace Leadofficelist\Forms;

use Laracasts\Validation\FormValidator;

class AddEditToolbox extends FormValidator {

	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'name'        => 'required',
		'description' => 'required|max:255',
		'type'        => 'required',
		'url'         => 'url',
		'file'        => 'required_if:type,file|max:10240'

	];

	public $messages = [
		'name.required'        => 'Please enter a name.',
		'description.required' => 'Please enter a description.',
		'url.active_url'       => 'Please enter a valid URL.',
		'url.url'              => 'Please enter a valid URL.',
		'file.required_if'     => 'Please select a file to upload.',
		'file.max'            => 'Please upload a file under 10mb in size.',
		'max'                  => 'Too many characters. Please reduce the text.'
	];
}