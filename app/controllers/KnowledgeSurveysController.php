<?php

use Laracasts\Commander\CommanderTrait;
use Leadofficelist\Forms\AddEditSurveys as AddEditSurveysForm;

class KnowledgeSurveysController extends \BaseController {

	use CommanderTrait;

	protected $resource_key = 'knowledge_surveys';
	protected $resource_permission = 'view_knowledge';
	/**
	 * @var
	 */
	private $addEditSurvey;

	function __construct( AddEditSurveysForm $addEditSurvey ) {
		parent::__construct();

		$this->check_perm( 'view_knowledge' );

		View::share( 'page_title', 'Knowledge Survey' );
		View::share( 'key', 'knowledge_surveys' );
		$this->addEditSurvey = $addEditSurvey;
	}

	/**
	 * Display a listing of the resource.
	 * GET /knowledgesurveys
	 *
	 * @return Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /knowledgesurveys/create
	 *
	 * @return Response
	 */
	public function create() {

		return View::make( 'knowledge_surveys.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /knowledgesurveys
	 *
	 * @return Response
	 */
	public function store() {
		//
	}

	/**
	 * Display the specified resource.
	 * GET /knowledgesurveys/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id ) {
		//
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

	public function getUpdateSurvey() {
		$dob_data          = $this->getDateSelect( 'dob' );
		$joined_fipra_data = $this->getDateSelect( 'joined_fipra' );
		$languages         = $this->getLanguages();
		$expertise         = $this->getExpertise();

		return View::make( 'knowledge_surveys.edit' )->with( compact( 'dob_data', 'joined_fipra_data', 'languages', 'expertise' ) );
	}

	public function postUpdateSurvey() {
		$input = Input::all();
		$this->addEditSurvey->validate( $input );
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

}