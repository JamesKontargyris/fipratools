<?php

use Laracasts\Commander\CommanderTrait;
use Leadofficelist\Forms\AddEditCase as AddEditCaseForm;

class CasesController extends \BaseController {

	use CommanderTrait;

	protected $resource_key = 'cases';
	protected $resource_permission = 'manage_cases';
	private $addEditCaseForm;
	private $case;
	private $addEditClientForm;

	function __construct( AddEditCaseForm $addEditCaseForm, CaseStudy $case ) {
		parent::__construct();
		View::share( 'page_title', 'Case Studies' );
		View::share( 'key', 'cases' );

		$this->addEditCaseForm = $addEditCaseForm;
		$this->case              = $case;
	}

	/**
	 * Display a listing of the resource.
	 * GET /cases
	 *
	 * @return Response
	 */
	public function index() {
		$this->check_perm( 'manage_cases' );

		$this->destroyCurrentPageNumber( true );

		if ( $this->searchCheck() ) {
			return Redirect::to( $this->resource_key . '/search' );
		}

		$items      = CaseStudy::rowsSortOrder( $this->rows_sort_order )->paginate( $this->rows_to_view );
		$items->key = 'cases';

		return View::make( 'cases.index' )->with( compact( 'items' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /cases/create
	 *
	 * @return Response
	 */
	public function create() {
		$this->check_perm( 'manage_cases' );

		$this->getFormData();

		return View::make( 'cases.create' )->with( [
			'account_directors' => $this->account_directors,
			'units'             => $this->units,
			'sectors'           => $this->sectors,
			'locations'         => $this->locations,
			'products'          => $this->products
		] );
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /cases
	 *
	 * @return Response
	 */
	public function store() {
		$this->check_perm( 'manage_cases' );

		$input = Input::all();
		$this->addEditCaseForm->validate( $input );

		$this->execute( 'Leadofficelist\Cases\AddCaseCommand', $input );

		Flash::overlay( '"' . $input['name'] . '" added.', 'success' );
		EventLog::add('Case study created: ' . $input['name'], $this->user->getFullName(), Unit::find($input['unit_id'])->name, 'add');

		return Redirect::route( 'cases.index' );
	}

	/**
	 * Display the specified resource.
	 * GET /cases/{id}
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
	 * GET /cases/{id}/edit
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
	 * PUT /cases/{id}
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
	 * DELETE /cases/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id ) {
		//
	}

}