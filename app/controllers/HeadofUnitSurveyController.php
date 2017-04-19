<?php

use Laracasts\Commander\CommanderTrait;
use Laracasts\Flash\Flash;
use Leadofficelist\Eventlogs\EventLog;
use Leadofficelist\Forms\AddEditHOUSurvey as AddEditHOUSurveyForm;
use Leadofficelist\Knowledge_data\KnowledgeData;
use Leadofficelist\Units\Unit;

class HeadofUnitSurveyController extends \BaseController {

	use CommanderTrait;

	public $section = 'headofunitsurvey';
	protected $resource_key = 'headofunitsurvey';
	protected $resource_permission = 'view_knowledge';
	protected $search_term;
	protected $units;
	protected $areas;
	protected $languages;
	private $addEditHOUSurvey;

	function __construct( AddEditHOUSurveyForm $addEditHOUSurvey ) {
		parent::__construct();

		View::share( 'page_title', 'Head of Unit Survey' );
		View::share( 'key', 'headofunitsurvey' );
		$this->addEditHOUSurvey = $addEditHOUSurvey;
	}

	/**
	 * Display a listing of the resource.
	 * GET /housurvey
	 *
	 * @return Response
	 */
	public function getIndex() {
		$this->check_role( ['Head of Unit', 'Administrator'] );

		$survey_name = 'head_of_unit_survey';

		$seniority = [
			''                  => 'Please select...',
			'supporting_staff'  => 'Supporting Staff',
			'trainee'           => 'Trainee',
			'researcher'        => 'Researcher',
			'account_executive' => 'Account Executive',
			'account_manager'   => 'Account Manager',
			'account_director'  => 'Account Director',
			'senior_adviser'    => 'Senior Adviser (does not run accounts)',
		];

		$unit_staff = ( isset( $this->user->unit_id ) ) ? Leadofficelist\Users\User::where( 'unit_id', '=', $this->user->unit_id )->where( 'id', '<>', $this->user->id )->orderby( 'last_name' )->get() : [];

		$unit_staff_names[ $this->user->getFullName() ] = $this->user->getFullName();
		foreach ( $unit_staff as $staff_member ) {
			$unit_staff_names[ $staff_member->getFullName() ] = $staff_member->getFullName();
		}

		$perception_audit = $this->getAllPerceptionAuditData();

		$other_data      = KnowledgeData::where( 'user_id', '=', $this->user->id )->where( 'survey_name', '=', $survey_name )->get()->toArray();
		$hou_survey_data = [];
		foreach ( $other_data as $data ) {
			$hou_survey_data[ $data['slug'] ] = $data['serialized'] ? unserialize( $data['data_value'] ) : $data['data_value'];
		}

		View::share( 'page_title', 'Head of Unit Survey' );

		return View::make( 'knowledge_surveys.headofunit_survey' )->with( compact( 'seniority', 'perception_audit', 'unit_staff', 'unit_staff_names', 'hou_survey_data', 'survey_name' ) );
	}

	public function postIndex()
	{
		$this->check_role( ['Head of Unit', 'Administrator'] );

		$input = Input::all();
		/*dd($input);*/
		// Add the perception audit areas into the validation rules and update feedback messages
		foreach ( $this->getAllPerceptionAuditData()['groups'] as $group_id => $area ) {
			foreach ( $area as $slug => $name ) {
				$this->addEditHOUSurvey->rules[ 'perception_audit.' . $slug ]                  = 'required|min:1|max:5';
				$this->addEditHOUSurvey->messages[ 'perception_audit.' . $slug . '.required' ] = 'Please select a score for ' . $name . '.';
			}
		}
		// Add each unit_staff_carrying_out_public_affairs row into the validation rules and update feedback messages
		if ( Input::has( 'unit_staff_carrying_out_public_affairs' ) ) {
			foreach ( Input::get( 'unit_staff_carrying_out_public_affairs' ) as $id => $row ) {
				if ( $id > 0 ) {
					$this->addEditHOUSurvey->rules["unit_staff_carrying_out_public_affairs.$id.name"]      = 'required';
					$this->addEditHOUSurvey->rules["unit_staff_carrying_out_public_affairs.$id.seniority"] = 'required';
				}
				$this->addEditHOUSurvey->messages["unit_staff_carrying_out_public_affairs.$id.name.required"]      = 'The Public Affairs staff "name" field is required.';
				$this->addEditHOUSurvey->messages["unit_staff_carrying_out_public_affairs.$id.seniority.required"] = 'The Public Affairs staff "seniority" field is required.';
			}
		}
		// Add each unit_staff_positions_in_public_office_people row into the validation rules and update feedback messages
		if ( Input::has( 'unit_staff_positions_in_public_office_people' ) ) {
			foreach ( Input::get( 'unit_staff_positions_in_public_office_people' ) as $id => $row ) {
				if ( $id > 0 ) {
					$this->addEditHOUSurvey->rules["unit_staff_positions_in_public_office_people.$id.name"]     = 'required';
					$this->addEditHOUSurvey->rules["unit_staff_positions_in_public_office_people.$id.position"] = 'required';
					$this->addEditHOUSurvey->rules["unit_staff_positions_in_public_office_people.$id.from"]     = 'required';
				}
				$this->addEditHOUSurvey->messages["unit_staff_positions_in_public_office_people.$id.name.required"]     = 'The staff holding positions in government or public office "name" field is required.';
				$this->addEditHOUSurvey->messages["unit_staff_positions_in_public_office_people.$id.position.required"] = 'The staff holding positions in government or public office "position" field is required.';
				$this->addEditHOUSurvey->messages["unit_staff_positions_in_public_office_people.$id.from.required"]     = 'The staff holding positions in government or public office "date appointed" field is required.';
			}
		}
		// Add each points_of_contact row into the validation rules and update feedback messages
		if ( Input::has( 'points_of_contact_people' ) ) {
			foreach ( Input::get( 'points_of_contact_people' ) as $id => $row ) {
				if ( $id > 0 ) {
					$this->addEditHOUSurvey->rules["points_of_contact_people.$id.name"] = 'required';
				}
				$this->addEditHOUSurvey->messages["points_of_contact_people.$id.name.required"] = 'The authorised person "name" field is required.';
			}
		}
		// Add each online_platform_other_details row into the validation rules and update feedback messages
		if ( Input::has( 'online_platform_other' ) ) {
			foreach ( Input::get( 'online_platform_other_details' ) as $id => $row ) {
				$this->addEditHOUSurvey->rules["online_platform_other_details.$id.name"]             = 'required';
				$this->addEditHOUSurvey->rules["online_platform_other_details.$id.url"]              = 'required|url';
				$this->addEditHOUSurvey->messages["online_platform_other_details.$id.name.required"] = 'The "Other" online platform "name" field is required.';
				$this->addEditHOUSurvey->messages["online_platform_other_details.$id.url.required"]  = 'The "Other" online platform "URL" field is required.';
				$this->addEditHOUSurvey->messages["online_platform_other_details.$id.url.url"]       = 'The "Other" online platform "URL" field is not valid.';
			}
		}

		// Validate input
		$this->addEditHOUSurvey->validate( $input );

		// Get rid of any existing rows, ready to add new ones for the new content
		KnowledgeData::where( 'user_id', '=', $this->user->id )->where( 'survey_name', '=', Input::get( 'survey_name' ) )->delete();

		// Add all fields into the knowledge_data table
		unset( $input['_token'] ); // remove _token field from array before inserting in DB
		unset( $input['survey_name'] ); // remove survey_name field from array before inserting in DB
		foreach ( $input as $slug => $value ) {
			$serialized = 0;
			if ( is_array( $value ) ) {
				$array_clean = [];
				if ( $slug != 'perception_audit' ) {
					foreach ( $value as $array ) {
						if ( ! emptyArray( $array ) ) {
							$array_clean[] = $array;
						}
					}
					$array_clean = removeDuplicateValues( $array_clean );
				} else {
					$array_clean = $value;
				}
				$value      = serialize( $array_clean ); // update $value to reflect clean array, or perception audit array
				$serialized = 1;
			}

			if ( $value ) { // If $value still contains data...
				KnowledgeData::addData( $this->user->id, $slug, $value, Input::get('survey_name'), $serialized );
			}
		}

		Flash::overlay( 'Head of Unit survey updated.', 'success' );
		EventLog::add( 'Head of Unit survey updated', $this->user->getFullName(), Unit::find( $this->user->unit_id )->name, 'edit' );

		return Redirect::to( 'survey/profile' );
	}

	protected function getAllPerceptionAuditData() {
		$perception_audit_data = [];

		$perception_audit_data['groups'][1] = [
			'importance_ability_to_react_quickly'                               => 'Ability to react quickly',
			'importance_reliability_effectiveness_of_its_members'               => 'Reliability / effectiveness of its members',
			'importance_wide_geographical_spread'                               => 'Wide geographical spread',
			'importance_focus_on_expertise_in_specific_industry_policy_sectors' => 'Focus on expertise in specific industry policy sectors (rather than in all political process)',
			'importance_high_age_experience_profile'                            => 'High age / experience profile',
			'importance_uniformity_of_output_quality_control'                   => 'Uniformity of output / quality control',
			'importance_friendship_collegiality'                                => 'Friendship / collegiality',
			'importance_member_cooperation_on_sales_marketing'                  => 'Member cooperation on sales / marketing',
			'importance_reputation_of_brand_within_business_community'          => 'Reputation of the brand within the business community',
		];
		$perception_audit_data['groups'][2] = [
			'achievement_ability_to_react_quickly'                               => 'Ability to react quickly',
			'achievement_reliability_effectiveness_of_its_members'               => 'Reliability / effectiveness of its members',
			'achievement_wide_geographical_spread'                               => 'Wide geographical spread',
			'achievement_focus_on_expertise_in_specific_industry_policy_sectors' => 'Focus on expertise in specific industry policy sectors (rather than in all political process)',
			'achievement_high_age_experience_profile'                            => 'High age / experience profile',
			'achievement_uniformity_of_output_quality_control'                   => 'Uniformity of output / quality control',
			'achievement_friendship_collegiality'                                => 'Friendship / collegiality',
			'achievement_member_cooperation_on_sales_marketing'                  => 'Member cooperation on sales / marketing',
			'achievement_reputation_of_brand_within_business_community'          => 'Reputation of the brand within the business community',
		];
		$perception_audit_data['groups'][3] = [
			'help_from_network_team_with_sales_marketing_branding' => 'Help from the Network Team with sales, marketing and branding',
			'quality_of_online_tools'                              => 'Quality of Online Tools provided (eg Lead Office List; Knowledge Survey; Fipra Tools etc.)',
			'provider_of_work_that_is_profitable_for_your_unit'    => 'Provider of work that is profitable for your Unit',
			'provider_of_public_affairs_services_in_brussels'      => 'Provider of public affairs services in Brussels',
			'efficiency_and_reliability_of_its_consultants'        => 'Efficiency and reliability of its consultants',
			'trustworthiness_and_transparency'                     => 'Trustworthiness and transparency',
			'smooth_management_of_network_by_network_team'         => 'Smooth management of the Network by the Network Team',
			'organisation_of_network_meetings_by_network_team'     => 'Organisation of Network Meetings by the Network Team',
			'manager_of_multinational_accounts'                    => 'Manager of multinational accounts',
			'financial_management'                                 => 'Financial management',
		];

		$perception_audit_data['questions'][1] = 'How important do you rate the qualities below in an ideal international PA network? (1 = not important; 5 = very important)';
		$perception_audit_data['questions'][2] = 'How well do you think the Fipra Network achieves these aims? (1 = poorly; 5 = very well)';
		$perception_audit_data['questions'][3] = 'How do you rate Fipra International as a Unit within the Network? (1 = poor; 5 = excellent)';

		return $perception_audit_data;
	}


}