<?php

use Laracasts\Commander\CommanderTrait;
use Leadofficelist\Exceptions\ProfileNotFoundException;
use Leadofficelist\Exceptions\ResourceNotFoundException;
use Leadofficelist\Forms\AddEditSurvey as AddEditSurveyForm;
use Leadofficelist\Knowledge_area_groups\KnowledgeAreaGroup;
use Leadofficelist\Knowledge_areas\KnowledgeArea;
use Leadofficelist\Knowledge_languages\KnowledgeLanguage;
use Leadofficelist\Knowledge_surveys\KnowledgeSurvey;
use Leadofficelist\Users\User;

class KnowledgeSurveysController extends \BaseController {

	use CommanderTrait;

	public $section = 'survey';
	protected $resource_key = 'knowledge_surveys';
	protected $resource_permission = 'view_knowledge';
	/**
	 * @var
	 */
	private $addEditSurvey;

	function __construct( AddEditSurveyForm $addEditSurvey ) {
		parent::__construct();

		$this->check_perm( 'view_knowledge' );

		View::share( 'page_title', 'Knowledge Survey' );
		View::share( 'key', 'knowledge_surveys' );
		$this->addEditSurvey = $addEditSurvey;
	}

	/**
	 * Display the current user's knowledge profile
	 * GET /knowledgesurveys
	 *
	 * @return Response
	 */
	public function index() {
		$this->destroyCurrentPageNumber( true );

		if ( $this->searchCheck() ) {
			// Keep any flashed messages when redirecting
			Session::reflash();

			return Redirect::to( $this->resource_key . '/search' );
		}

		$items      = User::where( 'date_of_birth', '!=', '0000-00-00' )->rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'survey';
		$user_info      = $this->user;

		return View::make( 'knowledge_surveys.index' )->with( compact( 'items', 'user_info' ) );
	}

	/**
	 * Show the current user's profile
	 * @return $this
	 * @throws ProfileNotFoundException
	 */
	public function getShowProfile() {
		$user_info      = $this->user;

		if ( isset( $this->user ) && $this->user->date_of_birth != '0000-00-00' ) {
			$language_info  = $this->getUserLanguageInfo();
			$expertise_info = $this->getExpertise();
			$score_info     = $this->getUserExpertiseInfoIDKeys();

			return View::make( 'knowledge_surveys.profile' )->with( compact( 'user_info', 'language_info', 'expertise_info', 'score_info' ) );
		} elseif ( isset( $this->user ) && $this->user->date_of_birth == '0000-00-00' ) {
			return View::make( 'knowledge_surveys.profile' )->with( compact( 'user_info', 'language_info', 'expertise_info', 'score_info' ) );
		}

		throw new ProfileNotFoundException();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /knowledgesurveys/create
	 *
	 * @return Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /knowledgesurveys
	 *
	 * @return Response
	 */
	public function store() {

	}

	/**
	 * Display another user's profile
	 * GET /knowledgesurveys/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 * @throws ProfileNotFoundException
	 */
	public function show( $id ) {
		$user = User::find($id);

		if(isset($user) && $user->survey_updated && $user->date_of_birth != '0000-00-00')
		{
			$user_info = $user;
			$language_info = $this->getUserLanguageInfo($id);
			$expertise_info = $this->getExpertise($id);
			$score_info = $this->getUserExpertiseInfoIDKeys($id);

			return View::make( 'knowledge_surveys.show' )->with(compact('user_info', 'language_info', 'expertise_info', 'score_info'));
		}

		throw new ProfileNotFoundException();
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /knowledgesurveys/{id}/edit
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /knowledgesurveys/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /knowledgesurveys/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id ) {
		//
	}

	public function getUpdateProfile() {

			$dob_data          = $this->getDateSelect( 'dob' );
			$joined_fipra_data = $this->getDateSelect( 'joined_fipra' );
			$languages         = $this->getLanguages();
			$expertise         = $this->getExpertise();

			$user_info = $this->user;
			if(isset($user_info))
			{
				$language_info = $this->getUserSpokenWrittenLanguages();
				/*dd($language_info);*/
				$fluency_info = $this->getUserFluentLanguages();
				$expertise_info = $this->getUserExpertiseInfoIDKeys();

				return View::make( 'knowledge_surveys.edit' )->with( compact( 'dob_data', 'joined_fipra_data', 'languages', 'expertise', 'user_info', 'language_info', 'fluency_info', 'expertise_info' ) );
			}

			return Redirect::to('survey/profile');

	}

	public function postUpdateProfile() {
		$input = Input::all();
		// Add the knowledge areas into the validation rules and update feedback messages
		foreach(KnowledgeArea::all() as $area) {
			$this->addEditSurvey->rules['areas.' . $area->id] = 'required|min:1|max:5';
			$this->addEditSurvey->messages['areas.' . $area->id . '.required'] = 'Please select an expertise score for ' . $area->name . '.';
		}
		// Validate input
		$this->addEditSurvey->validate( $input );
		/*print_r($input); die();*/

		$this->execute( 'Leadofficelist\Knowledge_surveys\UpdateKnowledgeInfoCommand' );
		$this->execute( 'Leadofficelist\Knowledge_surveys\UpdateLanguageInfoCommand' );
		$this->execute( 'Leadofficelist\Knowledge_surveys\UpdateUserInfoCommand' );

		Flash::overlay( 'Knowledge profile updated.', 'success' );

		return Redirect::to( 'survey/profile' );
	}

	protected function getDateSelect( $purpose = 'dob' ) {
		$data   = [];
		$months = array(
			"January",
			"February",
			"March",
			"April",
			"May",
			"June",
			"July",
			"August",
			"September",
			"October",
			"November",
			"December"
		);


		// Days
		for ( $i = 1; $i <= 31; $i ++ ) {
			$data['days'][ $i ] = strval( $i );
		}

		// Months
		for ( $i = 1; $i <= 12; $i ++ ) {
			$data['months'][ $i ] = $months[ $i - 1 ];
		}

		// Years
		if ( $purpose == 'joined_fipra' ) {
			// Only go back to 2000, when Fipra was formed
			$data['years'] = array_combine( range( date( "Y" ), 2000 ), array_map( 'strval', range( date( "Y" ), 2000 ) ) );

		} else {
			// Go back to 1910 for date of birth entry
			$data['years'] = array_combine( range( date( "Y" ), 1910 ), array_map( 'strval', range( date( "Y" ), 1910 ) ) );
		}

		return $data;
	}

	protected function getLanguages() {
		$languages_processed = [];
		$languages           = KnowledgeLanguage::orderBy( 'name', 'ASC' )->get();

		foreach ( $languages as $language ) {
			$languages_processed[ $language->id ] = $language->name;
		}

		return $languages_processed;
	}

	protected function getExpertise() {
		$expertise             = [];
		$knowledge_area_groups = KnowledgeAreaGroup::orderBy( 'order' )->get()->toArray();
		foreach ( $knowledge_area_groups as $group ) {
			$expertise['descriptions'][ $group['name'] ] = $group['description'];
			$knowledge_areas                             = KnowledgeArea::where( 'knowledge_area_group_id', '=', $group['id'] )->orderBy( 'name' )->get()->toArray();
			foreach ( $knowledge_areas as $area ) {
				$expertise['areas'][ $group['name'] ][ $area['id'] ] = $area['name'];
			}
		}

		return $expertise;
	}

	protected function getUserLanguageInfo($id = null)
	{
		// Get language data via the pivot table
		$languages    = $id ? User::find($id)->knowledge_languages()->get() : $this->user->knowledge_languages()->get();
		$languageData = [];

		foreach($languages as $language)
		{
			// Create an array with language names as keys and fluent flag as values
			$languageData[$language->name] = $language->pivot->fluent;
		}

		return $languageData;
	}

	protected function getUserSpokenWrittenLanguages($id = null)
	{
		$languages_processed = [];
		// Get language data via the pivot table
		$languages    = $id ? User::find($id)->knowledge_languages()->get()->toArray() : $this->user->knowledge_languages()->get()->toArray();

		foreach($languages as $language) {
			$languages_processed[] = $language['id'];
		}

		return $languages_processed;

	}

	protected function getUserFluentLanguages($id = null)
	{
		$languages_processed = [];
		// Get language data via the pivot table
		$fluent_languages    = $id ? User::find($id)->knowledge_languages()->where('fluent', '=', 1)->get()->toArray() : $this->user->knowledge_languages()->where('fluent', '=', 1)->get()->toArray();

		foreach($fluent_languages as $language) {
			$languages_processed[] = $language['id'];
		}

		return $languages_processed;
	}

	protected function getUserExpertiseInfo($id = null)
	{
		// Get language data via the pivot table

		$expertise    = $id ? User::find($id)->knowledge_areas()->get() : $this->user->knowledge_areas()->get();
		$expertiseData = [];

		foreach($expertise as $expert)
		{
			// Create an array with expertise names as keys and scores as values
			$expertiseData[$expert->name] = $expert->pivot->score;
		}

		// Put into alphabetical order
		asort($expertiseData, SORT_STRING);

		return $expertiseData;
	}

	protected function getUserExpertiseInfoIDKeys($id = null)
	{
		// Get language data via the pivot table
		$expertise    = $id ? User::find($id)->knowledge_areas()->get() : $this->user->knowledge_areas()->get();
		$expertiseData = [];

		foreach($expertise as $expert)
		{
			// Create an array with expertise names as keys and scores as values
			$expertiseData[$expert->id] = $expert->pivot->score;
		}

		// Put into alphabetical order
		asort($expertiseData, SORT_STRING);

		return $expertiseData;
	}

}