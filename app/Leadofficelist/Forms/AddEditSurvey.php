<?php namespace Leadofficelist\Forms;

use KnowledgeArea;
use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FactoryInterface as ValidatorFactory;

class AddEditSurvey extends FormValidator {
	/**
	 * Validation rules for adding a sector
	 *
	 * @var array
	 */
	public $rules = [
		'dob_day'                            => 'required',
		'dob_month'                          => 'required',
		'dob_year'                           => 'required',
		'languages'                          => 'array|required',
		'expertise_team'                     => 'array|required',
		'pa_pr_organisations_details'        => 'required_if:pa_pr_organisations,1',
		'registered_lobbyist_details'        => 'required_if:registered_lobbyist,1',
		'formal_positions_details'           => 'required_if:formal_positions,1',
		'political_party_membership_details' => 'required_if:political_party_membership,1',
		'other_network_details'              => 'required_if:other_network,1',
	];

	public $messages = [
		'languages.required'                      => 'Please select the languages in which you can conduct business.',
		'expertise_team.required'                 => 'Please select the team(s) you would place yourself in.',
		'pa_pr_organisations_details.required_if' => 'Please enter your professional public affairs or public relations organisation(s) details.',
		'registered_lobbyist_details.required_if' => 'Please enter your registered lobbyist details.',
		'formal_positions.required_if'            => 'Please enter your formal title and/or position details.',
		'political_party_membership.required_if'  => 'Please enter your political party membership details.',
		'other_network.required_if'               => 'Please enter details of your network membership(s).',
	];
}